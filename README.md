# Barangay Bulletin – Purok Ancog

Lab Activity 10 for 4-334 Full-Stack Web Development. A small blog where barangay officials publish posts that residents can browse, search and page through. Built with Laravel, Eloquent, SQLite, Blade and Tailwind CSS.

**Student:** Greece Ancog

## Personalized values

| Item | Value |
| --- | --- |
| Posts per page | **6**. My last name, Ancog, has 5 letters, so the lab's minimum of 6 applies. |
| Custom category | **Disaster Preparedness** |
| Birthday post date | **June 17, 2026** ("Purok Ancog Clean-up Drive", pinned) |
| Kagawad author | Kagawad Greece Ancog, kagawad.ancog@bulletin.test |

## How to run

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve
```

Keep `npm run dev` and `php artisan serve` running in two terminals, then open http://127.0.0.1:8000.

If `database/database.sqlite` does not exist, create it before migrating. On Windows PowerShell, run `New-Item database/database.sqlite`.

After seeding there are 5 authors and 51 posts: 40 published, 10 drafts, and the pinned birthday post.


