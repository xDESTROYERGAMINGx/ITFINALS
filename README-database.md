## CKC Grading System – Clean Database Template

This file contains the cleaned version of the CKC Grading System database, ready for deployment or testing.

---

##  File Included
- `ckc_grading_system.sql` – a cleaned SQL dump file

---

##  What’s Inside the Cleaned Database
- All student-related data has been removed
- Only the following accounts remain:
  - Admin account (`id = 1`)
  - Faculty account (`faculty_id = 3`, Joshua Atis)
- Subject allocations are preserved for faculty_id = 3
- All subject definitions are intact
- AUTO_INCREMENT counters have been reset
- Foreign key constraints and indexes are untouched

---

##  How to Use
1. Open phpMyAdmin or your SQL client
2. Import the file `ckc_grading_system.sql`
3. The system will be ready for fresh student registration and grading setup

---
##  Environment Configuration

After importing the database, update your `.env` file to match the new database name:

```env
DB_DATABASE=ckc_grading_system

##  Group 5 – Database Team
This cleaned database was prepared by Group 5, assigned to handle the database setup and management for the CKC Grading System final project.
