Provides a service for getting comic releases by way of scraping data from [comiclist.com](http://www.comiclist.com/index.php). This project was initially devised as a way of creating and testing a simple site scraping class for use in other projects. This means that this service will exist as long as Comic List does or they block the IP. Which ever occurs first.

## Endpoints

The base url will return all publishers and titles for the current week.

Example base url call:
```
https://ghostbox.design/api/comics
```

Example JSON returned:

```
[{
	"publisher": "DC COMICS",
	"titles": ["Batman #1",
            "Superman #1"]
},
{
	"publisher": "MARVEL COMICS",
	"titles": ["Spider-Man #1",
            "Uncanny X-Men #1"]
}]
```

It also accepts three additional parameters.

### week

This allows you to select the required weeks data. Accepts either ```this```, ```next``` or ```last```.

Example call:
```
https://ghostbox.design/api/comics?week=next
```

### publishers

Accepts a comma separated list of comic publishers.

Example call:
```
https://ghostbox.design/api/comics?publishers=dc%20comics,marvel%20comics
```

At time of creation the available publishers were:

Abrams Comicarts, Action Lab Entertainment, Aftershock Comics, American Gothic Press, Amigo Comics, Antarctic Press, Archie Comic Publications, Aspen Comics, Big Finish, Blizzard Entertainment, BOOM! Studios, Broadsword Comics, Cinebook, Comic Shop News, Danger Zone, Dark Horse Comics, Dark Planet, DC Comics, Dead Reckoning, Drawn And Quarterly, Dynamic Forces, Dynamite Entertainment, Ember, Fantagraphics Books, First Second, Gallery 13, Golden Apple Books, Hachette Partworks, Graphic India, IDW Publishing, Image Comics, Keenspot Entertainment, Kodansha Comics, Last Gasp, Lion Forge, Margaret K Mcelderry Books, Marvel Comics, Nobrow, Panini Publishing, Oni Press, Ps Artbooks, Random House Books For Young Readers, Rebellion/2000 Ad, Renegade Arts Entertainment, Sanctum Productions, Scout Comics, Stone Arch Books, Titan Comics, Tohan Corporation, Tokyopop, University Press Of Mississippi, Viz Media, William Morrow, Zenescope Entertainment

### titles

Will return an unordered list of all titles without publishers. Accepts boolean of ```1``` or ```0```.
If ```publisher``` is also set as a parameter it will be ignored.

Example call:
```
https://ghostbox.design/api/comics?titles=1
```

### novariants

Including this parameter will strip all references to variant covers or cover options, returning only one version per comic title. Accepts boolean of ```1``` or ```0```. So if variants are not required pass ```1```.

Example call:
```
https://ghostbox.design/api/comics?novariants=1
```

## Issues

Please feel free to report any issues on the [Github page](https://github.com/raw-bit/ComicsAPI/issues).
