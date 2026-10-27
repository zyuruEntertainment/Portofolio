# Portfolio Profile + Admin Dashboard Fix

This is an overlay patch for `zyuruEntertainment/Portofolio`. Copy the included paths into the matching paths in the Laravel project, replacing files when prompted.

## What this fixes/adds

- Adds the missing public `ProfileController`.
- Adds the missing authenticated `AdminProfileController` and `AdminProfile` model.
- Adds the `admin_profiles` migration.
- Adds the public profile page and admin edit-profile page.
- Keeps the Explore page's existing Profile link and route name.
- Keeps the admin dashboard landing content intentionally empty.
- Adds the three sidebar items; only Profile navigates. Projects and Social Media are disabled placeholders and have no pages.
- Replaces the corrupted `public/css/admin.css` with clean CSS. The repository version contained stray tool/terminal command text and repeated garbage at the end.
- Adds profile icon upload, validation, preview, save/update behavior, and a minimal responsive layout.

## Apply on Windows (PowerShell)

From the project folder, extract this ZIP and copy/merge its contents into `D:\Portofolio`. Make sure the paths remain exactly as shown inside the ZIP.

Then run:

```powershell
php artisan migrate
php artisan storage:link
php artisan route:list
php artisan test
```

If `storage:link` already exists, Laravel may report that the link already exists; that is okay.

The image upload uses Laravel's `public` disk and stores images under `storage/app/public/profile-icons`. The public URL is `storage/profile-icons/...`.

## Important

The existing admin login needs an admin record in the `admins` table. This patch does not create or change admin credentials. If you have not created the admin account yet, use your existing secure admin-creation method.

The public profile is blank/default until an admin saves the form at `/admin/profile`. The dashboard at `/admin/dashboard` remains empty apart from the header and sidebar, as requested.

This is a source overlay, not a verified deployment. Run the commands above locally and inspect `git diff` before committing.
