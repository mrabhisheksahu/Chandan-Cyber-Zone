# Chandan Cyber Zone (PVC)

Common Service Center Webpage for customer document ordering & uploads.

## Backend (PHP + SQLite)
- `config.php`: DB connection (SQLite `pvc.db` auto-created).
- `admin/login.php`: Admin login (demo).
- `order.php`: Order form handler (GET `?doc=NAME`).
- `admin/dashboard.php`: View orders.

## Setup
1. Install XAMPP for Windows.
2. Start Apache (PHP 8+).
3. Copy all files to `C:\xampp\htdocs\pvc` (or any folder under `htdocs`).
4. Access:
   - Frontend: `http://localhost/pvc/`
   - Admin: `http://localhost/pvc/admin/login.php`
5. Test order: `http://localhost/pvc/order.php?doc=Aadhar+Card` (uploads go to `uploads/`).

## Notes
- SQLite DB files and `uploads/` are excluded from GitHub (for safety/security).

=======
# PVC Card Clone - RDM SUPER FAST PRINT

## Frontend Clone
- `index.html`: Main page with document cards.
- `assets/images/*.png`: 14 document icons.

## Backend Clone (PHP + SQLite)
- `config.php`: DB connection (SQLite `pvc.db` auto-created).
- `admin/login.php`: Admin login (admin/admin123).
- `order.php`: Order form handler (GET ?doc=NAME).
- `admin/dashboard.php`: View orders.

## Setup
1. Install [XAMPP](https://www.apachefriends.org/download.html) for Windows.
2. Start Apache (PHP 8+).
3. Copy all files to `C:\xampp\htdocs\pvc-clone\`.
4. Access:
  - Frontend: `http://localhost/pvc-clone/`
  - Admin: `http://localhost/pvc-clone/admin/login.php`
5. Test order: `http://localhost/pvc-clone/order.php?doc=Aadhar+Card` - submit form (files to `uploads/`).

## DB Schema
- `admins`: username, password (hashed).
- `orders`: doc_type, full_name, mobile, address..., price=139.00, status='Pending'.

## Notes
- Payment: Mock (status Pending).
- File uploads: Stored in `uploads/` (create dir chmod 777 on Linux).
- Original DB dump needed for full data migration.
- Links in index.html updated to PHP.

>>>>>>> f1b383e (Initial commit)
=======
# Chandan Cyber Zone (PVC)

Common Service Center Webpage for customer document ordering & uploads.

## Backend (PHP + SQLite)
- `config.php`: DB connection (SQLite `pvc.db` auto-created).
- `admin/login.php`: Admin login (demo).
- `order.php`: Order form handler (GET `?doc=NAME`).
- `admin/dashboard.php`: View orders.

## Setup
1. Install XAMPP for Windows.
2. Start Apache (PHP 8+).
3. Copy all files to `C:\xampp\htdocs\pvc` (or any folder under `htdocs`).
4. Access:
   - Frontend: `http://localhost/pvc/`
   - Admin: `http://localhost/pvc/admin/login.php`
5. Test order: `http://localhost/pvc/order.php?doc=Aadhar+Card` (uploads go to `uploads/`).

## Notes
- SQLite DB files and `uploads/` are excluded from GitHub.

=======
# Chandan Cyber Zone (PVC)

Common Service Center Webpage for customer document ordering & uploads.

## Backend (PHP + SQLite)
- `config.php`: DB connection (SQLite `pvc.db` auto-created).
- `admin/login.php`: Admin login (demo).
- `order.php`: Order form handler (GET `?doc=NAME`).
- `admin/dashboard.php`: View orders.

## Setup
1. Install XAMPP for Windows.
2. Start Apache (PHP 8+).
3. Copy all files to `C:\xampp\htdocs\pvc` (or any folder under `htdocs`).
4. Access:
   - Frontend: `http://localhost/pvc/`
   - Admin: `http://localhost/pvc/admin/login.php`
5. Test order: `http://localhost/pvc/order.php?doc=Aadhar+Card` (uploads go to `uploads/`).

## Notes
- SQLite DB files and `uploads/` are excluded from GitHub (for safety/security).

=======
# PVC Card Clone - RDM SUPER FAST PRINT

## Frontend Clone
- `index.html`: Main page with document cards.
- `assets/images/*.png`: 14 document icons.

## Backend Clone (PHP + SQLite)
- `config.php`: DB connection (SQLite `pvc.db` auto-created).
- `admin/login.php`: Admin login (admin/admin123).
- `order.php`: Order form handler (GET ?doc=NAME).
- `admin/dashboard.php`: View orders.

## Setup
1. Install [XAMPP](https://www.apachefriends.org/download.html) for Windows.
2. Start Apache (PHP 8+).
3. Copy all files to `C:\xampp\htdocs\pvc-clone\`.
4. Access:
  - Frontend: `http://localhost/pvc-clone/`
  - Admin: `http://localhost/pvc-clone/admin/login.php`
5. Test order: `http://localhost/pvc-clone/order.php?doc=Aadhar+Card` - submit form (files to `uploads/`).

## DB Schema
- `admins`: username, password (hashed).
- `orders`: doc_type, full_name, mobile, address..., price=139.00, status='Pending'.

## Notes
- Payment: Mock (status Pending).
- File uploads: Stored in `uploads/` (create dir chmod 777 on Linux).
- Original DB dump needed for full data migration.
- Links in index.html updated to PHP.

>>>>>>> f1b383e (Initial commit)
