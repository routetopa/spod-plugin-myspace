# MySpace

### About this plugin

My space is the place where each user can manage datalets, text and link in a personal area, as a reminder or for later use within a post (in What's new or in the Public 
rooms of the Agora).

Each content is placed in a "card". You can add in a card a URL, a datalet (visualization of a dataset) or plain text, simply by clicking on the big "+" button in the bottom 
right. In order to display the content of a card, just click on the blue button in the middle of the card. Each card has also a title (in black background) and a comment 
(below the title). For each card, on the top, you can modify (pencil icon) or delete it (basket) The layout of the cards follows the temporal order (most recent first). 
You can create different types of cards:

* Link card
* Text card
* OpenData Visualization

To display content just click on the blue button in the middle of the card. When a user tries to view its own datalets in their private space, SPOD does not contacts the actual 
data provider but retrieves the data from its own database. This allows in a great speed improvement and in a better user experience.

You will be able to use the contents created in the this area to post visualizations or links in the *What's New area* (in the figure on the left) or in the *Public Rooms* 
within the *Agora*.

### Installation guide

To install *MySpace* plugin:

* Clone this project by following the github instruction on *SPOD_INSTALLATION_DIR/ow_plugins*
* Go to *MySpace Admin Panel* and set the *COMPONENTS URL*. The *COMPONENTS URL* is the endpoint of the repository of the *datalets* and *controllets* definitions(See **DEEP** 
and **COMPONENTS** projects to get more information).