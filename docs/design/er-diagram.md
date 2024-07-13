```mermaid

erDiagram
    users ||--o{ specification_documents: "1人の会員は複数のテスト仕様書を持つ"
    departments ||--o{ users: "１つの課は複数の会員を持つ"
    departments ||--o{ projects: "１つの課は複数のプロジェクトを持つ"
    projects ||--o{ specification_documents: "1つのプロジェクトは複数のテスト仕様書を持つ"
    specification_documents ||--o{ specification_document_sheets: "1つの仕様書は複数のシートを持つ"
    user_agents ||--o{ specification_document_sheets: "一つのUAは複数のシートも持つ"
    specification_document_sheets ||--o{ specification_document_items: "1つのシートは複数の項目を持つ"
    specification_document_items ||--o{ specification_document_items: "1つの項目は複数の項目を持つ"
    users ||--o{ user_specification_documents: "1人の会員は複数の仕様書を対応できる"
    specification_documents ||--o{ user_specification_documents: "1つの仕様書は複数の対応者を持つ"

    users {
        bigint id PK
        bigint department_id FK "部署ID"
        varchar(255) name
        varchar(255) email "メールアドレス"
        varchar(255) password
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
        timestamp deleted_at "削除日時"
    }
    departments {
        bigint id PK
        varchar(255) name "部署名"
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
        timestamp deleted_at
    }
    projects {
        bigint id PK
        bigint department_id FK
        varchar(255) name
        text summary "概要"
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
        timestamp deleted_at "削除日時"
    }
    specification_documents {
        bigint id PK
        bigint user_id FK "users.id"
        bigint project_id FK "projects.id"
        string title
        string summary "概要"
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
        timestamp deleted_at "削除日時"
    }
    specification_document_sheets {
        bigint id PK
        bigint spec_doc_id FK "specification_documents.id"
        bigint user_agent_id FK "user_agents.id"
        int status_id "0: Pending, 1: In progress, 2: Completed, 3: NG"
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
    }
    specification_document_items {
        bigint id PK
        bigint spec_doc_sheet_id FK "specification_document_sheets.id"
        bigint parent_item_id FK "specification_document_items.id"
        text body "本文"
        text remark "備考"
        bool has_check
        tinyint status_id "0: Pending, 1: OK, 2: NG"
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
    }
    user_specification_documents {
        bigint id PK
        bigint user_id FK "users.id"
        bigint spec_doc_id FK "specification_documents.id"
        timestamp created_at "作成日時"
        timestamp updated_at "更新日時"
        timestamp deleted_at "削除日時"
    }
    user_agents {
        bigint id PK
        varchar(255) name
        timestamp created_at "作成日時"
    }
    admins {
        bigint id PK
        varchar(255) password
        timestamp created_at "作成日時"
    }
