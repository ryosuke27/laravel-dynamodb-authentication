# laravel-dynamodb-authentication

## 概要

Laravel フレームワークを利用した Web アプリケーションと DynamoDB でログイン認証を
できるようにするライブラリです。

Laravel の既存の middleware を介して利用することができるためクッキーなど
Laravel が用意している認証機能をそのまま利用することができます。

## セットアップ

driverをdynamoDbProvider に変更：
**config/auth.php**

```
 'users' => [
            'driver' => 'dynamoDbProvider', ⇦変更
            'model' => App\Models\User::class,
        ],
```

AuthServiceProviderの設定をdynamoDbProviderに変更：
**app/Providers/AuthServiceProvider.php**

```
 public function boot()
    {
        $this->registerPolicies();

        Auth::provider('dynamoDbProvider', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new DynamoDbProvider();
        });
    }
```
