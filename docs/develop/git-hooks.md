# Git hooks

- [公式サイト](https://git-scm.com/book/ja/v2/Git-%E3%81%AE%E3%82%AB%E3%82%B9%E3%82%BF%E3%83%9E%E3%82%A4%E3%82%BA-Git-%E3%83%95%E3%83%83%E3%82%AF)

### pre-commit設定

- pre-commitで静的解析及びフォーマット

> [!WARNING]
> CLIにてcommit,push時にメッセージが表示されることを確認

1. チームと共有用のGit hooksの参照先ディレクトリを作成

```shell
mkdir .githooks
```

2. Git hooksの参照先ディレクトリを変更

```shell
git config --local core.hooksPath .githooks
```

3. [.githooks/pre-commit](/.githooks/pre-commit)作成&記述
4. 実行権限付与

```shell
chmod a+x ./.githooks/pre-commit
```

### pre-push設定

- pre-pushで自動テスト

1. [.githooks/pre-push](/.githooks/pre-push)作成&記述
2. 実行権限付与

```shell
chmod a+x ./.githooks/pre-push
```
