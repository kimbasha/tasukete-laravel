# タスケテ - データベーススキーマ仕様

## 概要

当日券特化型予約サービス「タスケテ 〜HELP ME!!〜」のデータベース設計書

## テーブル一覧

### 1. troupes（劇団）

劇団の基本情報を管理するテーブル

| カラム名 | 型 | 制約 | 説明 |
|---------|-----|------|------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | 劇団ID |
| name | VARCHAR(255) | NOT NULL | 劇団名 |
| description | TEXT | NULL | 劇団の説明・紹介文 |
| website | VARCHAR(255) | NULL | 公式サイトURL |
| created_at | TIMESTAMP | NOT NULL | 作成日時 |
| updated_at | TIMESTAMP | NOT NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY (id)

---

### 2. performances（公演）

公演情報を管理するテーブル

| カラム名 | 型 | 制約 | 説明 |
|---------|-----|------|------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | 公演ID |
| troupe_id | BIGINT UNSIGNED | NOT NULL, FOREIGN KEY | 劇団ID（troupes.id） |
| title | VARCHAR(255) | NOT NULL | 公演タイトル |
| description | TEXT | NULL | 公演の説明 |
| venue | VARCHAR(255) | NOT NULL | 会場名 |
| area | ENUM | NOT NULL | エリア（下北沢/新宿/渋谷/池袋/その他） |
| area_detail | VARCHAR(100) | NULL | エリア詳細（「その他」選択時のみ入力） |
| performance_date | DATE | NOT NULL | 公演日 |
| start_time | TIME | NOT NULL | 開演時刻 |
| door_open_time | TIME | NULL | 開場時刻 |
| poster_image_url | VARCHAR(255) | NULL | ポスター画像URL |
| ticket_price | INTEGER | NOT NULL | チケット価格（円） |
| reservation_url | VARCHAR(255) | NULL | 予約URL |
| has_day_tickets | BOOLEAN | NOT NULL, DEFAULT false | 当日券販売フラグ |
| status | ENUM | NOT NULL, DEFAULT 'upcoming' | ステータス（upcoming/today/ended） |
| created_at | TIMESTAMP | NOT NULL | 作成日時 |
| updated_at | TIMESTAMP | NOT NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY (id)
- INDEX (troupe_id)
- INDEX (performance_date)
- INDEX (area)
- INDEX (status)

**外部キー:**
- troupe_id REFERENCES troupes(id) ON DELETE CASCADE

**ENUM定義:**
- area: '下北沢', '新宿', '渋谷', '池袋', 'その他'
- status: 'upcoming', 'today', 'ended'

---

### 3. admin_users（管理者）

管理者アカウント情報を管理するテーブル

| カラム名 | 型 | 制約 | 説明 |
|---------|-----|------|------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ユーザーID |
| email | VARCHAR(255) | NOT NULL, UNIQUE | メールアドレス |
| password | VARCHAR(255) | NOT NULL | パスワード（ハッシュ化） |
| role | ENUM | NOT NULL, DEFAULT 'super_admin' | 権限（super_admin/theater_admin） |
| troupe_id | BIGINT UNSIGNED | NULL, FOREIGN KEY | 管理する劇団ID（theater_adminの場合のみ） |
| created_at | TIMESTAMP | NOT NULL | 作成日時 |
| updated_at | TIMESTAMP | NOT NULL | 更新日時 |

**インデックス:**
- PRIMARY KEY (id)
- UNIQUE (email)
- INDEX (troupe_id)

**外部キー:**
- troupe_id REFERENCES troupes(id) ON DELETE CASCADE

**制約:**
- theater_adminの場合はtroupe_idが必須
- super_adminの場合はtroupe_idはNULL

**ENUM定義:**
- role: 'super_admin', 'theater_admin'

---

## リレーションシップ

```
admin_users (N) ---< troupe_id >--- (1) troupes
troupes (1) ---< troupe_id >--- (N) performances
```

### 詳細

1. **admin_users → troupes (N:1)**
   - theater_adminは1つの劇団のみ管理可能
   - super_adminはtroupe_id = NULL

2. **troupes → performances (1:N)**
   - 1つの劇団は複数の公演を持つ
   - 劇団削除時は公演も削除（CASCADE）

---

## 権限設計

### super_admin（システム管理者）
- 全ての劇団・公演を管理可能
- 劇団の作成・削除が可能
- 管理者アカウントの作成が可能

### theater_admin（劇団管理者）
- 自分の劇団のみ編集可能
- 自分の劇団の公演のみ作成・編集・削除可能
- 劇団の削除は不可

---

## ビジネスルール

### 当日券の表示ロジック

1. **has_day_tickets = true** → 「当日券あり」表示（青色バッジ）
2. **has_day_tickets = false** → 「当日券なし」表示（グレーバッジ）

**Note:** スモールスタートのため、残券数管理は行わず当日券の有無のみを管理します。将来的に予約システムを実装する際に、在庫管理機能を追加することを想定しています。

### ステータスの自動更新

- `status`フィールドは公演日に基づいて自動更新される想定
- upcoming: 公演日が未来
- today: 公演日が今日
- ended: 公演日が過去

---

## マイグレーション順序（参考）

Laravel移行時のマイグレーション作成順序:

1. `create_troupes_table`
2. `create_admin_users_table`（troupes参照）
3. `create_performances_table`（troupes参照）
4. `add_troupe_id_to_admin_users_table`（theater_admin機能追加時）

---

## 注意事項

### PostgreSQL → MySQL移行時の注意

1. **BIGINT UNSIGNED**
   - PostgreSQL: `BIGINT`（符号付き）
   - MySQL: `BIGINT UNSIGNED`（符号なし）
   - Laravelのデフォルトは`BIGINT UNSIGNED`なので、どちらでも動作する

2. **ENUM型**
   - 両方で使用可能だが、MySQLのENUMは後から値を追加しにくい
   - Laravelでは文字列カラムとして定義し、バリデーションで制限する方法も検討

3. **TIMESTAMP**
   - PostgreSQL: `TIMESTAMPTZ`（タイムゾーン付き）
   - MySQL: `TIMESTAMP`

4. **ON DELETE CASCADE**
   - 両方で使用可能、同じ動作

5. **AUTO_INCREMENT**
   - PostgreSQL: `SERIAL`または`BIGSERIAL`
   - MySQL: `AUTO_INCREMENT`
   - Laravelのマイグレーションでは`$table->id()`で自動的に対応

---

生成日: 2025-12-24
