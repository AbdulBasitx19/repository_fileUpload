# 📁 Laravel File Upload System with Repository Pattern

A robust, clean-code Laravel application demonstrating secure and organized file handling (Public & Private storage) using the **Repository Pattern**, **Service Layer**, and **Dependency Injection**.

## 🎯 Project Overview

This project is designed to showcase advanced Laravel architectural patterns while solving a real-world problem: **Secure File Management**. It clearly separates concerns by dividing the application into Controllers (HTTP handling), Services (Business Logic), and Repositories (Data & Storage Operations).

It handles two types of file storage:
1. **Public Files**: Accessible directly via URL (e.g., profile pictures, public documents).
2. **Private Files**: Securely stored outside the public web root, accessible only through a controlled, authenticated download response.

## 🚀 Key Features

- ✅ **Repository Pattern**: Decouples database/storage logic from business logic.
- ✅ **Service Layer**: Handles complex business rules (e.g., unique filename generation, disk selection).
- ✅ **Dependency Injection**: Loose coupling via Interface binding in Service Providers.
- ✅ **Form Request Validation**: Strict validation for file types (`mimes`), size (`max:2048`), and required fields.
- ✅ **Dual Storage Management**: Seamless switching between `public` and `local` (private) disks.
- ✅ **Secure Downloads**: Private files are streamed via Laravel responses, hiding the actual server path.
- ✅ **Automatic Cleanup**: Deleting a record automatically removes the physical file from the storage disk.
- ✅ **Clean UI**: Simple, responsive Blade templates with inline CSS for quick testing.

## 🏛️ Architecture & Flow

```text
User Request
    ↓
[Form Request] → Validates file (type, size, required fields)
    ↓
[Controller] → Thin controller, receives validated data, calls Service
    ↓
[Service] → Business Logic (Generates unique filename, decides disk)
    ↓
[Repository Interface] → Contract for storage operations
    ↓
[Repository] → Executes Storage::disk()->putFileAs() and DB::create()
    ↓
[Storage/Database] → File saved & metadata recorded

```


## 🛠️ Tech Stack
Backend: Laravel 11.x, PHP 8.2+
Database: MySQL
Frontend: Blade Templates, Vanilla HTML/CSS
Architecture: Repository Pattern, Service Layer, Dependency Injection
File Handling: Laravel Storage Facade (public & local disks)

📂 Project Structure
app/
├── Http/
│   ├── Controllers/
│   │   └── DocumentController.php          # Thin controller (Request/Response)
│   └── Requests/
│       └── StoreDocumentRequest.php        # File validation rules
├── Interfaces/
│   └── DocumentRepositoryInterface.php     # Contract for repository methods
├── Repositories/
│   └── DocumentRepository.php              # Actual Storage & DB operations
├── Services/
│   └── DocumentService.php                 # Business logic (filename generation, disk routing)
├── Models/
│   └── Document.php                        # Eloquent model with $fillable
└── Providers/
    └── RepositoryServiceProvider.php       # Binds Interface to Repository

resources/views/documents/
└── index.blade.php                         # Upload form & file lists (Public/Private)

storage/
├── app/public/documents/                   # Publicly accessible files
└── app/private_documents/                  # Secure, non-web-accessible files


📦 Installation & Setup
Follow these steps to get the project running locally:
Prerequisites
PHP 8.2 or higher
Composer
MySQL
Git
Step-by-Step Setup
1. **Clone the repository** :
       git clone https://github.com/YOUR_USERNAME/repository_file_upload.git
        cd repository_file_upload
2. **Install PHP dependencies** :
       composer install
3.  **Setup Environment**:
    Copy the example environment file: cp .env.example .env
    Update your database credentials in the .env file:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=repository_fileUpload
    DB_USERNAME=root
    DB_PASSWORD=
4. **Generate Application Key**:
       php artisan key:generate
5. **Run Migrations**:
       php artisan migrate
6. **Create Storage Symlink (CRUCIAL for Public Files)**:
    php artisan storage:link
7. **Start Development Server**:
    php artisan serve
    




