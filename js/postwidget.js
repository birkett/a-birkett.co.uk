/**
 * Quick functions to allow collapsing the posts widget
 *
 * Javascript
 *
 * @category  Javascript
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

// This is not inside a function, so it runs on page load.
var spans       = document.getElementsByTagName('span');
var spansLength = spans.length;

for (var i = 0; i < spansLength; i++) {
    spans[i].onclick = function()
    {
        if (this.parentNode) {
            var childList       = this.parentNode.getElementsByTagName('UL');
            var childListLength = childList.length;

            for (var j = 0; j < childListLength; j++) {
                var currentState = childList[j].style.display;
                if (currentState === "none") {
                    childList[j].style.display = "block";
                } else {
                    childList[j].style.display = "none";
                }
            }
        }

        // Prevent redirect on click.
        return false;

    }

    spans[i].onclick();
}//end for


/**
 * Toggle the posts widget visibility
 * @return void
 */
function togglePosts()
{
    var h2 = document.getElementById("allposts");
    if (h2.style.display === "none" || h2.style.display === "") {
        h2.style.display = "block";
    } else {
        h2.style.display = "none";
    }

}//end togglePosts()
