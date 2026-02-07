# test-Fleamarket

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:risa912/test-Fleamarket.git`
2. cd test-Fleamarket
3. DockerDesktopアプリを立ち上げる 
4. Docker コンテナの起動（初回はビルド）
```bash
docker-compose up -d --build
```

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

### メール送信確認（MailHog）
1. .envに以下のメール設定（MailHog）
``` text
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Stripe（決済機能）設定
1. .envに以下のStripe（決済）設定（テスト環境）
``` text
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxx
```
2. docker-compose.ymlに以下の設定を追加 （MailHog）
``` text
mailhog:
        image: mailhog/mailhog
        ports:
            - "1025:1025"
            - "8025:8025"
```

3. config/services.php の設定
```text
'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

### Stripe 利用のための PHP 拡張設定（bcmath）
1. Dockerfileを以下の内容で修正。
``` text
FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip bcmath

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www
```

2. 以下のコマンドを実行してコンテナを再ビルド
` docker-compose down` 
` docker-compose build --no-cache` 
` docker-compose up -d` 

3. bcmath 有効化の確認
` docker-compose exec php bash` 
` php -m | grep bcmath` 

`bcmath` が表示されれば成功です。

4. Stripe SDK のインストール
` composer require stripe/stripe-php` をインストール

## Laravel 初期化
1. Laravel の設定キャッシュをクリア
``` bash
php artisan config:clear
```

2. アプリケーションキーの作成
``` bash
php artisan key:generate
```

3. マイグレーションの実行
``` bash
php artisan migrate
```

4. シーディングの実行
``` bash
php artisan db:seed
```

5. シンボリックリンク作成
``` bash
php artisan storage:link
```

## 使用技術(実行環境)
- PHP8.4.11
- Laravel8.83.29
- MySQL8.0.43
- Docker / Docker Compose
- MailHog（メール送信確認）
- Laravel Fortify（認証機能）
- Stripe（テスト環境）

## テーブル設計
### users テーブル
| カラム名 | 型 | PK | UNIQUE | NOT NULL | 外部キー |
|--------|----|----|--------|----------|----------|
| id | bigint unsigned | ○ | | | |
| name | varchar(255) | | | ○ | |
| email | varchar(255) | | ○ | ○ | |
| password | varchar(255) | | | ○ | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### items テーブル
| カラム名 | 型 | PK | NOT NULL | 外部キー |
|--------|----|----|----------|----------|
| id | bigint unsigned | ○ | | |
| name | varchar(255) | | ○ | |
| price | integer | | ○ | |
| brand | varchar(255) | | | |
| description | varchar(255) | | ○ | |
| image | varchar(255) | | ○ | |
| condition_id | bigint unsigned | | ○ | conditions(id) |
| user_id | bigint unsigned | | ○ | users(id) |
| created_at | timestamp | | | |
| updated_at | timestamp | | | |

### categories テーブル
| カラム名 | 型 | PK | NOT NULL |
|--------|----|----|----------|
| id | bigint unsigned | ○ | |
| name | varchar(255) | | ○ |
| created_at | timestamp | | |
| updated_at | timestamp | | |

### item_categories テーブル
| カラム名 | 型 | PK | NOT NULL | 外部キー |
|--------|----|----|----------|----------|
| id | bigint unsigned | ○ | | |
| item_id | bigint unsigned | | ○ | items(id) |
| category_id | bigint unsigned | | ○ | categories(id) |
| created_at | timestamp | | | |
| updated_at | timestamp | | | |

### conditions テーブル
| カラム名 | 型 | PK | NOT NULL |
|--------|----|----|----------|
| id | bigint unsigned | ○ | |
| condition | varchar(255) | | ○ |
| created_at | timestamp | | |
| updated_at | timestamp | | |

### item_likes テーブル
| カラム名 | 型 | PK | NOT NULL | 外部キー |
|--------|----|----|----------|----------|
| id | bigint unsigned | ○ | | |
| user_id | bigint unsigned | | ○ | users(id) |
| item_id | bigint unsigned | | ○ | items(id) |
| created_at | timestamp | | | |
| updated_at | timestamp | | | |

### comments テーブル
| カラム名 | 型 | PK | NOT NULL | 外部キー |
|--------|----|----|----------|----------|
| id | bigint unsigned | ○ | | |
| user_id | bigint unsigned | | ○ | users(id) |
| item_id | bigint unsigned | | ○ | items(id) |
| comment | varchar(255) | | ○ | |
| created_at | timestamp | | | |
| updated_at | timestamp | | | |

### profiles テーブル
| カラム名 | 型 | PK | NOT NULL | 外部キー |
|--------|----|----|----------|----------|
| id | bigint unsigned | ○ | | |
| name | varchar(255) | | ○ | |
| image | varchar(255) | | ○ | |
| postal_code | varchar(255) | | ○ | |
| address | varchar(255) | | ○ | |
| building | varchar(255) | | | |
| user_id | bigint unsigned | | ○ | users(id) |
| created_at | timestamp | | | |
| updated_at | timestamp | | | |

### purchases テーブル
| カラム名 | 型 | PK | NOT NULL | 外部キー |
|--------|----|----|----------|----------|
| id | bigint unsigned | ○ | | |
| image | varchar(255) | | ○ | |
| postal_code | varchar(255) | | ○ | |
| address | varchar(255) | | ○ | |
| building | varchar(255) | | | |
| item_id | bigint unsigned | | ○ | items(id) |
| user_id | bigint unsigned | | ○ | users(id) |
| created_at | timestamp | | | |
| updated_at | timestamp | | | |

## ER図
![alt](ファイル名.png)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/

