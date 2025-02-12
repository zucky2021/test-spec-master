# DB

## CLIでMySQLに接続

```shell
sail up -d && sail mysql
```

```sql
SELECT VERSION();
```

Result
```SQL
+-----------+
| VERSION() |
+-----------+
| 8.0.32    |
+-----------+
1 row in set (0.02 sec)
```

## DBeaver

[公式サイト](https://dbeaver.io/)

### Local env connection

1. コンテナ起動
1. 新しい接続で**MySQL**を選択
3. ex: .envファイルから接続情報を取得
4. テスト接続
[![Image from Gyazo](https://i.gyazo.com/052fe108c1a2b576fb371922d9c74548.png)](https://gyazo.com/052fe108c1a2b576fb371922d9c74548)
