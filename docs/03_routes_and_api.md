# タスケテ - ルーティング・API仕様書

## エンドユーザー向けルート

### 公開ページ

| メソッド | URL | コントローラー | アクション | 説明 |
|---------|-----|--------------|-----------|------|
| GET | / | PerformanceController | index | 公演一覧表示 |
| GET | /performances/{id} | PerformanceController | show | 公演詳細表示 |

---

## 管理画面ルート

### 認証

| メソッド | URL | コントローラー | アクション | 説明 |
|---------|-----|--------------|-----------|------|
| GET | /admin/login | Auth\LoginController | showLoginForm | ログイン画面 |
| POST | /admin/login | Auth\LoginController | login | ログイン処理 |
| POST | /admin/logout | Auth\LoginController | logout | ログアウト処理 |

### ダッシュボード

| メソッド | URL | コントローラー | アクション | 説明 |
|---------|-----|--------------|-----------|------|
| GET | /admin | Admin\DashboardController | index | ダッシュボード表示 |

### 劇団管理

| メソッド | URL | コントローラー | アクション | 説明 |
|---------|-----|--------------|-----------|------|
| GET | /admin/troupes | Admin\TroupeController | index | 劇団一覧 |
| GET | /admin/troupes/create | Admin\TroupeController | create | 劇団作成画面（super_adminのみ） |
| POST | /admin/troupes | Admin\TroupeController | store | 劇団作成処理 |
| GET | /admin/troupes/{id}/edit | Admin\TroupeController | edit | 劇団編集画面 |
| PUT/PATCH | /admin/troupes/{id} | Admin\TroupeController | update | 劇団更新処理 |
| DELETE | /admin/troupes/{id} | Admin\TroupeController | destroy | 劇団削除処理（super_adminのみ） |

### 公演管理

| メソッド | URL | コントローラー | アクション | 説明 |
|---------|-----|--------------|-----------|------|
| GET | /admin/performances | Admin\PerformanceController | index | 公演一覧 |
| GET | /admin/performances/create | Admin\PerformanceController | create | 公演作成画面 |
| POST | /admin/performances | Admin\PerformanceController | store | 公演作成処理 |
| GET | /admin/performances/{id}/edit | Admin\PerformanceController | edit | 公演編集画面 |
| PUT/PATCH | /admin/performances/{id} | Admin\PerformanceController | update | 公演更新処理 |
| DELETE | /admin/performances/{id} | Admin\PerformanceController | destroy | 公演削除処理 |

### ユーザー管理

| メソッド | URL | コントローラー | アクション | 説明 |
|---------|-----|--------------|-----------|------|
| GET | /admin/users | Admin\UserController | index | ユーザー一覧（super_adminのみ） |
| GET | /admin/users/create | Admin\UserController | create | ユーザー作成画面 |
| POST | /admin/users | Admin\UserController | store | ユーザー作成処理 |
| GET | /admin/users/{id}/edit | Admin\UserController | edit | ユーザー編集画面 |
| PUT/PATCH | /admin/users/{id} | Admin\UserController | update | ユーザー更新処理 |
| DELETE | /admin/users/{id} | Admin\UserController | destroy | ユーザー削除処理 |

---

## ミドルウェア

### 認証ミドルウェア

```php
// routes/web.php

// 公開ページ
Route::get('/', [PerformanceController::class, 'index'])->name('home');
Route::get('/performances/{id}', [PerformanceController::class, 'show'])->name('performances.show');

// 管理画面（認証必要）
Route::prefix('admin')->name('admin.')->group(function () {
    // 認証前
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // 認証後
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // 劇団管理
        Route::resource('troupes', TroupeController::class);

        // 公演管理
        Route::resource('performances', PerformanceController::class);

        // ユーザー管理（super_adminのみ）
        Route::middleware('can:manage-users')->group(function () {
            Route::resource('users', UserController::class);
        });
    });
});
```

---

## API仕様（Inertia.js使用時）

### レスポンス形式

Inertia.jsを使用する場合、コントローラーは `Inertia::render()` でVueコンポーネントにデータを渡します。

```php
// 例: 公演一覧
public function index(Request $request)
{
    $performances = Performance::with('troupe')
        ->where('performance_date', '>=', now()->toDateString())
        ->orderBy('performance_date')
        ->orderBy('start_time')
        ->get();

    return Inertia::render('Performances/Index', [
        'performances' => $performances,
    ]);
}
```

---

## バリデーションルール

### 劇団作成・更新

```php
[
    'name' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'website' => ['nullable', 'url', 'max:255'],
]
```

### 公演作成・更新

```php
[
    'troupe_id' => ['required', 'integer', 'exists:troupes,id'],
    'title' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'venue' => ['required', 'string', 'max:255'],
    'area' => ['required', 'in:下北沢,新宿,渋谷,池袋,その他'],
    'area_detail' => ['nullable', 'string', 'max:100'],
    'performance_date' => ['required', 'date'],
    'start_time' => ['required', 'date_format:H:i'],
    'door_open_time' => ['nullable', 'date_format:H:i'],
    'ticket_price' => ['required', 'integer', 'min:0'],
    'reservation_url' => ['nullable', 'url', 'max:255'],
    'has_day_tickets' => ['boolean'],
    'poster_image' => ['nullable', 'image', 'max:5120'], // 5MB
]
```

### ユーザー作成

```php
[
    'email' => ['required', 'email', 'max:255', 'unique:admin_users,email'],
    'password' => ['required', 'string', 'min:8', 'confirmed'],
    'role' => ['required', 'in:super_admin,theater_admin'],
    'troupe_id' => ['required_if:role,theater_admin', 'nullable', 'integer', 'exists:troupes,id'],
]
```

### ユーザー更新

```php
[
    'email' => ['required', 'email', 'max:255', 'unique:admin_users,email,' . $id],
    'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    'role' => ['required', 'in:super_admin,theater_admin'],
    'troupe_id' => ['required_if:role,theater_admin', 'nullable', 'integer', 'exists:troupes,id'],
]
```

---

## 認可（Policies）

### TroupePolicy

```php
class TroupePolicy
{
    // 劇団一覧を見る権限
    public function viewAny(AdminUser $user): bool
    {
        return true; // 全ての管理者が自分の劇団を見れる
    }

    // 劇団詳細を見る権限
    public function view(AdminUser $user, Troupe $troupe): bool
    {
        return $user->role === 'super_admin' || $user->troupe_id === $troupe->id;
    }

    // 劇団を作成する権限
    public function create(AdminUser $user): bool
    {
        return $user->role === 'super_admin';
    }

    // 劇団を更新する権限
    public function update(AdminUser $user, Troupe $troupe): bool
    {
        return $user->role === 'super_admin' || $user->troupe_id === $troupe->id;
    }

    // 劇団を削除する権限
    public function delete(AdminUser $user, Troupe $troupe): bool
    {
        return $user->role === 'super_admin';
    }
}
```

### PerformancePolicy

```php
class PerformancePolicy
{
    // 公演を見る権限
    public function view(AdminUser $user, Performance $performance): bool
    {
        return $user->role === 'super_admin' || $user->troupe_id === $performance->troupe_id;
    }

    // 公演を作成する権限
    public function create(AdminUser $user): bool
    {
        return true; // theater_adminも自劇団の公演を作成可能
    }

    // 公演を更新する権限
    public function update(AdminUser $user, Performance $performance): bool
    {
        return $user->role === 'super_admin' || $user->troupe_id === $performance->troupe_id;
    }

    // 公演を削除する権限
    public function delete(AdminUser $user, Performance $performance): bool
    {
        return $user->role === 'super_admin' || $user->troupe_id === $performance->troupe_id;
    }
}
```

---

## クエリ最適化

### Eager Loading

```php
// 公演一覧（劇団名も表示）
Performance::with('troupe')->get();

// 劇団一覧（公演数も表示）
Troupe::withCount('performances')->get();
```

### スコープ

```php
// Performanceモデル
public function scopeUpcoming($query)
{
    return $query->where('performance_date', '>=', now()->toDateString());
}

public function scopeToday($query)
{
    return $query->whereDate('performance_date', now());
}

public function scopeByArea($query, $area)
{
    return $query->where('area', $area);
}

// 使用例
Performance::upcoming()->byArea('下北沢')->get();
```

---

## セキュリティ

### CSRF保護
- Laravelのデフォルトミドルウェアで対応
- Inertia.jsでも自動的に処理される

### XSS対策
- Bladeテンプレート: `{{ }}` で自動エスケープ
- Vue: `v-html`は使わない、テキスト表示は`{{ }}`

### SQL Injection対策
- Eloquent ORM使用で自動的に対応
- Raw Queryを使う場合はバインディング使用

### 画像アップロード
- MIMEタイプチェック
- ファイルサイズ制限（5MB）
- ファイル名のサニタイズ

---

生成日: 2025-12-24
