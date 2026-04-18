# Fix Siswa Terpopuler &amp; Dashboard

## Steps:
- [ ] 1. Edit api/populate_students.php: Remove session check, add &#39;rank&#39; = index (0 first = terpopuler), upsert all (update existing).
- [ ] 2. Run `php api/populate_students.php`
- [ ] 3. Edit api/index.php: Change students sort to [&#39;rank&#39; => -1, &#39;name&#39; => 1]
- [ ] 4. Test dashboard (`php -S localhost:8000`)
- [ ] Done
