# Barangay Bulletin – Purok Ancog

Lab Activity 11 for 4-334 Full-Stack Web Development. It builds on my Lab 10 bulletin: barangay officials publish posts, and now residents can log in and comment, posts carry tags, and each author has a profile page. Built with Laravel, Eloquent, SQLite, Blade and Tailwind CSS.

**Student:** Greece Ancog

## Seeded logins

Both accounts use the password `bulletin2026` (stored hashed).

| Name | Email | Can do |
| --- | --- | --- |
| Lola Ancog | lola.ancog@bulletin.test | Comment on posts (resident, no author profile, so creating a post returns 403) |
| Kagawad Greece Ancog | kagawad.ancog@bulletin.test | Comment and create posts (linked to the Kagawad author profile) |

The seeder also creates 8 resident accounts with the user factory (password `password`).

## My 5 tags

**Purok Ancog**, **Urgent**, **Health**, **Ayuda**, **Disaster Preparedness**

Every post gets 1–3 random tags. The pinned "Purok Ancog Clean-up Drive" post always has exactly Purok Ancog and Urgent (set with `sync()`).

## Relationships and why I used each type

| Link | Type | Why |
| --- | --- | --- |
| User → Author | `hasOne` / `belongsTo` | One login account owns at most one author profile. The FK `authors.user_id` is `unique`, which is what makes it one-to-one, and `nullOnDelete` keeps the author's posts if the account is deleted. `StorePostRequest` uses it to let only users with an author profile post. |
| Author → Post | `hasMany` / `belongsTo` | One author writes many posts; each post has one author (`posts.author_id`). New posts are created through `$user->author->posts()->create()`. |
| Post → Comment | `hasMany` / `belongsTo` | A post has many comments; each comment belongs to one post (`comments.post_id`). Comments are created through `$post->comments()->create()`. |
| User → Comment | `hasMany` / `belongsTo` | A user writes many comments; each comment has one writer (`comments.user_id`), set from the logged-in user, never the form. |
| Post ↔ Tag | `belongsToMany` (both sides) | A post has many tags and a tag is on many posts, so the link needs the `post_tag` pivot (singular names, alphabetical order) with a composite primary key so a tag can't be attached twice. Tags are only ever written with `attach()` / `sync()`. |
| Author → Comment | `hasManyThrough` (via Post) | Comments don't store an author, so "N comments received" hops authors → posts → comments in one query instead of loading every post. |

## Eager loading

`Model::preventLazyLoading()` is on outside production, so any N+1 query throws instead of running silently. The index uses `with(['author', 'tags'])->withCount('comments')`, the show page uses `load()` for `author`, `tags` and nested `comments.user`, and the author page eager-loads its post cards the same way.

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

After seeding there are 5 authors, 51 posts (40 published, 10 drafts, plus the pinned birthday post), 10 users, 5 tags, and 0–5 comments on each published post. The pinned post has 3 comments, including one from Lola.

## Personalized values from Lab 10

| Item | Value |
| --- | --- |
| Posts per page | **6**. My last name, Ancog, has 5 letters, so the lab's minimum of 6 applies. |
| Custom category | **Disaster Preparedness** |
| Birthday post date | **June 17, 2026** ("Purok Ancog Clean-up Drive", pinned) |
| Kagawad author | Kagawad Greece Ancog, kagawad.ancog@bulletin.test |
