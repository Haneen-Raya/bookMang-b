# Simple Book Management System - Project Analysis

## Project Idea

This project aims to build a simple web system for managing books using the Laravel 12 framework. The system allows users (assumed to be system administrators) to add, edit, view, and delete (including soft delete, restore, and permanent delete) information related to books, authors, and categories.

## Analysis

Based on the project requirements and the provided code, the core entities, their attributes, and the relationships between them have been identified as follows:

### Core Entities

1.  **Author**: Represents the author of the book.
    *   **Attributes:**
        *   `id`: Unique identifier (Primary Key).
        *   `name`: Author's name (String, Required).
        *   `email`: Author's email (String, Required, Unique).
        *   `created_at`, `updated_at`: Creation and update timestamps (Timestamps).
        *   `deleted_at`: Soft delete timestamp (Timestamp, Nullable - Supports Soft Deletes).
    *   **Relationships:**
        *   A single author can have multiple books (One-to-Many with Book).

2.  **Category**: Represents the category or genre of the book.
    *   **Attributes:**
        *   `id`: Unique identifier (Primary Key).
        *   `name`: Category name (String, Required).
        *   `created_at`, `updated_at`: Timestamps.
        *   `deleted_at`: Soft delete timestamp (Timestamp, Nullable - Supports Soft Deletes).
    *   **Relationships:**
        *   A single category can belong to multiple books (Many-to-Many with Book).

3.  **Book**: Represents the book itself.
    *   **Attributes:**
        *   `id`: Unique identifier (Primary Key).
        *   `title`: Book title (String, Required).
        *   `body`: Content or description of the book (Text, Required).
        *   `cover`: Path to the book's cover image (String, Nullable).
        *   `author_id`: Identifier of the associated author (Foreign Key, Required).
        *   `created_at`, `updated_at`: Timestamps.
        *   `deleted_at`: Soft delete timestamp (Timestamp, Nullable - Supports Soft Deletes).
    *   **Relationships:**
        *   A single book belongs to one author (Many-to-One with Author).
        *   A single book can belong to multiple categories (Many-to-Many with Category).
        *   A single book can have multiple additional images (One-to-Many with Image).

4.  **Image**: Represents additional images associated with the book.
    *   **Attributes:**
        *   `id`: Unique identifier (Primary Key).
        *   `images`: Path to the image file (String, Required - The column name might be slightly misleading, but it stores the image path).
        *   `book_id`: Identifier of the associated book (Foreign Key, Required).
        *   `created_at`, `updated_at`: Timestamps.
    *   **Relationships:**
        *   A single image belongs to one book (Many-to-One with Book).

### Additional Analysis Notes:

*   **User**: The standard Laravel `User` model and its associated tables (users, sessions, password_reset_tokens) are included, but there are no custom user management functions within the basic CRUD scope of the current project.
*   **Validation**: `FormRequest` is used for each entity to ensure the validity of input data (e.g., required fields, unique email, allowed file types, etc.).
*   **Soft Deletes**: Soft deletion is implemented for Authors, Categories, and Books, with additional functionality for Authors to view trashed items, restore them, and delete them permanently.
*   **File Management**: Uploading and deleting cover images and additional images are handled, storing them in the public filesystem (`public/storage`).

## Technologies Used

*   **Framework:** Laravel 12
*   **Programming Language:** PHP 8.2
*   **Database:** (Configurable via `.env`, default SQLite) with Eloquent ORM.
*   **Frontend:** Blade Templates, Tailwind CSS, Vite
*   **Dependency Management:** Composer (PHP), NPM (Frontend)

---
