# Hi, Supermetrics!
Thanks for taking the time to talk to me the other day. Here is my technical assessment as requested.
## Methodology and Justification
### Server Side
Post gathering and parsing is mostly performed server-side with the exception of some minor formatting which is done in the Vue application.

The server-side application is built by using an abstract base class which contains common functionality for the GetPostsByPage and GetUserData classes. This is to ensure that the code remains in easily maintainable files with strongly separated concerns.

The Application uses a naming convention that would allow it to work with an SPL Autoloader with minimal (or zero) configuration.

The classes are coded to a tweaked version of PSR-2 standards (I prefer some extra spacing around my logic blocks), and use DocBlock comments.

There is a suite of PHP unit tests in the 'tests->php' folder.
### Client Side
The client side application is built with Vue. My exposure to SPA JavaScript frameworks is limited, so I'm afraid I had to learn Vue from scratch for this, so I hope that the client-side app looks ok.

The client side consists of three apps, a homepage (with a copy of this message), a 'posts' page, which has the post listing, and a 'dashboard' page for displaying each user's post date.

For convenience, I've added a function to the dashboards page that fetches all the available users, and allows you to select one from a drop-down menu, which will then load their dashboard.

I haven't added much in the way of styling, but I've used Bootstrap in there for some basic structure.

## Application Structure
### Server-side (API)
* Application
  * PHP Application files
* tests
  * PHP - PHP Unit tests
### Client-side (Client)
* Standard Vue CLI configuration
