## About Project

This project talks about a book fair
Each book has reviews and rating
You can add a maximum of 3 reviews per hour, thanks to RateLimiter
Because in this project we used fack data , we did not use index and show in the BookController
So I Used

- [Model](./app/Models/).
I Makeing Some Locale Scope In Book Model And I Use Relationship Has Many (reviews)

- [2 Controller](./app/Http/Controllers/).
I Used With Book Controller (Cache) I Cached My Data In File And I Can Chached In Redis
In ReviewController I Can Use Relationship By Book To Create New Reviews

- [view](./resources/views/)
I Make Some views in resources folder And I Create [Layout](./resources/views/layout/app.blade.php)
I will used basics TailwindCss And I Generate Custem Style By Tailwind
I Use Component To Display Count of Rating

And I Used In [RouteServiceProvider](./app/Providers/RouteServiceProvider.php)
I created RateLimiter to respond to any attempt to create rating more than 3 per hour 
This By Throttle Middleware
