# Test

## Server side

- PHPUnit
  - Git hooks - pre-pushで自動化
  ```zsh
  sail artisan test
  ```
  - 実装時に特定のクラスのみテスト実行
  ```zah
  sail artisan test tests/Feature/Admin/ProjectTest.php
  ```
