# Deployment Guide: Bank Sampah Production

This document provides instructions for deploying **The Organic Breath (Bank Sampah)** to a shared hosting environment or private server.

## 🚀 Deployment Steps

### 1. Database Setup
1.  Open your hosting control panel (e.g., cPanel).
2.  Create a new MySQL Database and User.
3.  Import the [production_schema.sql](production_schema.sql) file via **phpMyAdmin**.
4.  Update the credentials in `includes/db_connect.php` (inside the `else` block).

### 2. File Upload
Upload all files **EXCEPT** those listed in the "Ignore List" below.

> [!IMPORTANT]
> Ensure the `uploads/` directory has **write permissions** (CHMOD 755 or 775) on the server to allow user avatar and product image uploads.

### 3. Environment Variable
If your server supports `.htaccess` or environment variables, ensure `IS_LOCAL_DOCKER` is **NOT** set to `true`. By default, the code handles this automatically for standard hosting.

---

## 📁 File Manifest

### ✅ Files to Upload
| Path | Description |
| :--- | :--- |
| `index.php`, `login.php`, `register.php` | Main entry points |
| `admin/`, `user/`, `api/`, `includes/` | Core logic and UI |
| `css/output.css` | **Critical**: Compiled styles |
| `manifest.json`, `sw.js` | **Critical**: PWA implementation |
| `assets/`, `js/`, `css/style.css` | Static assets |
| `uploads/` | User-generated content directory |

### ❌ Ignore List (Do NOT Upload)
| Path | Reason |
| :--- | :--- |
| `node_modules/` | Development dependencies |
| `src/`, `css/input.css` | Source files for compilation |
| `tailwind.config.js`, `package.json` | Build configuration |
| `drizzle.config.ts`, `db/` | Schema management (local only) |
| `seed.ts`, `insert_dummy_*.php` | Seed scripts |
| `test_*.php`, `debug_*.php` | Testing and debugging tools |
| `.git/`, `.gitignore` | Version control metadata |
| `docker-compose.yml`, `Dockerfile` | Local environment only |

---
*Prepared for production deployment.*
