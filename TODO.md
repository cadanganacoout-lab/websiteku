# Restrict Student Management to Admin Role Only

## Status: [IN PROGRESS] ⏳

### Plan Breakdown:
1. ✅ [DONE] Understand files & issue (auth sets admin session for all logins)
2. ✅ Edit api/proses_register.php - Add 'role' => 'user' for new registrations
3. ✅ Edit api/auth.php - Check user role before setting admin session
4. ✅ Edit api/index.php - Strengthen server-side admin checks for CRUD (add_student requires $is_admin, update strengthened)
5. [PENDING] 🧪 Test non-admin login (no panel), admin login (full access)
6. ✅ Update TODO.md

**Next Step**: Edit api/proses_register.php
