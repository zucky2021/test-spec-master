# Debug

## PHP

### XDebug

#### Install

1. インストール確認
```shell
sail php -v
```

Result
```shell
PHP 8.3.9 (cli) (built: Jul  5 2024 12:03:46) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.3.9, Copyright (c) Zend Technologies
    with Zend OPcache v8.3.9, Copyright (c), by Zend Technologies
    with Xdebug v3.3.2, Copyright (c) 2002-2024, by Derick Rethans
```

2. 拡張機能**PHP Debug**インストール
3. [.vscode/launch.json](/.vscode/launch.json)作成および記述
4. [.env](/.env)記述
5. コンテナ再起動
6. ブレークポイント設置
7. サイドバーから**実行とデバッグ**アイコン押下 > **Listen for Xdebug**選択 > **デバッグの開始**アイコン押下
8. `XDEBUG_SESSION=1`クエリパラメータを付けてページ読み込み
