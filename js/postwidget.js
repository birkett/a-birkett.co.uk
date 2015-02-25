/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * Javascript
 *
 * @category  Javascript
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

// Quick functions to all collapsing the posts widget.

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
