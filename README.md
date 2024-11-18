## 專案檔案結構
```
01157006_refactored_fixed/
├─ public/                     # 對外可見的頁面
│  ├─ index.php
│  ├─ login.php
│  ├─ register.php
│  ├─ home.php
│  └─ css/
│     └─ styles.css
├─ src/
│  ├─ config/
│  │  └─ conn.php              # 資料庫連線（支援環境變數，否則使用預設）
│  └─ controllers/
│     ├─ process_login.php
│     ├─ process_register.php
│     └─ process_change_password.php
├─ docs/                        # 作業文件
│  ├─ 測試網頁截圖.pdf
│  └─ 對照表及資料庫說明.pdf
├─ .env                         # 環境變數
└─ README.md  
```

---

## 環境建置流程

### 1. 安裝 XAMPP [Apache Friends](https://www.apachefriends.org/zh_tw/index.html)
- 安裝後啟動 **XAMPP Control Panel**，按下：
  - **Start Apache**
  - **Start MySQL**

### 2. 放置專案
- 將整個專案資料夾 `Secure-Login-System/` 放到：
  ```
  C:\xampp\htdocs\
  ```
- 完整路徑應為：
  ```
  C:\xampp\htdocs\Secure-Login-System\public\index.php
  ```

### 3. 建立資料庫
- 打開 XAMPP 控制面板 → **MySQL → Admin**，進入 phpMyAdmin
- 執行以下 SQL：
  ```sql
  CREATE DATABASE information_security_hw1;
  USE information_security_hw1;

  CREATE TABLE account (
      username VARCHAR(16) PRIMARY KEY,
      realname VARCHAR(16),
      password VARCHAR(255),
      password1 VARCHAR(255),
      password2 VARCHAR(255)
  );

  CREATE TABLE rec_login (
      username VARCHAR(16),
      login_time DATETIME,
      result BOOLEAN,
      locked BOOLEAN,
      ip_address VARCHAR(45)
  );
  ```

### 4. 瀏覽專案
- 開啟瀏覽器，輸入：
  ```
  http://localhost/Secure-Login-System/public/
  ```
- 可以進入：
  - `register.php` → 註冊帳號
  - `login.php` → 登入
  - `home.php` → 登入成功頁面（含改密碼功能）

---

## 功能
- 註冊：限制帳號重複，密碼需符合規則
- 登入：錯誤三次會鎖定帳號五分鐘，並記錄登入紀錄 (帳號、IP、時間、成功/失敗)
- 修改密碼：需輸入舊密碼、新密碼需符合規則，且不可與前三次密碼相同
- Session 管理：登入成功顯示「歡迎，<姓名>」

---

## 測試與文件
- 測試情境：`docs/測試網頁截圖.pdf`  
- 功能與程式對照：`docs/對照表及資料庫說明.pdf`

---

## 注意事項
- 若專案資料夾名稱改變，要修改各 `controller` 檔案頂端的：
  ```php
  define('BASE_URL', '/Secure-Login-System');
  ```

- `.env.` 填入 DB 資訊

