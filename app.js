/**
 * this function is called when an image is clicked on the index page.
 * the image url (path), label and description is taken and passed to another function as a arguments
 * enlargeImage calls modalFrame function
 * enlargeImage calls setDisplay function
 * enlargeImage calls changeTextOnCloseBtn function
 * enlargeImage calls unsetDisplay function
 * @param {*} el
 */
function enlargeImage(el) {
    /*
        $output .= "<div class='image-frame' onclick='enlargeImage(this)';>";
        $output .= "<img src='" . $imageInfo['url']. "' alt=''  class='image'> ";
        $output .= "<h3 class='label'>". $imageInfo['label'] ."</h3>";
        $output .= "<p class='description'>". $imageInfo['description'] ."</p>";
        $output .= "</div>";
    */
    
    // the whole of div.image-frame is el
    // it has 3 children, url, label and description, respectively
    var imageUrl = el.children[0]
    var imageLabel = el.children[1]
    var imageDescription = el.children[2]

    // to obtain the image file path as is in the file system or db
    var imageUrlToArray = imageUrl.src.split('/')
    var folder = imageUrlToArray[imageUrlToArray.length - 2]
    var filename = imageUrlToArray[imageUrlToArray.length - 1]

    var url = folder + '/' + filename
    var label = imageLabel.textContent
    var description = imageDescription.textContent
    
    // console.log("url: " + url)
    // console.log("label: " + label)
    // console.log("description: " + description)

    // pass url, label and description as arguments to modalFrame
    modalFrame(url, label, description)

    // call setDisplay
    setDisplay()

    // call changeTextOnCloseBtn
    changeTextOnCloseBtn()

    // call unsetDisplay to exit the modal mode
    // and move to where the image was
    // here we pass the id of the parent frame as an arg
    // i.e image-frame
    unsetDisplay(el.id)
}


/**
 * has three params, url, label and description
 * url: image path
 * label is label and description is description
 * url is passed a value to the src attr in img
 * label and description are passed as textContent to the p's
 * @param {*} url 
 * @param {*} label 
 * @param {*} description 
 */
function modalFrame(url, label, description) {
    /* 
        <div class="modal-frame">
            <img src="" alt="" id="modal-url">
            <h1 id="modal-label"></h1>
            <p id="modal-description"></p>
        </div>
    */

   document.getElementById("modal-url").src = url
   document.getElementById("modal-label").textContent = label
   document.getElementById("modal-description").textContent = description
}


/**
 * sets the display property of top to none
 * and that of bg-modal to flex (or anything useful like block)
 */
function setDisplay() {
    document.getElementsByClassName('top')[0].style.display = 'none'
    document.getElementsByClassName('bg-modal')[0].style.display = 'block'
}


/**
 * sets the display property of top to flex (or anything useful like block)
 * and that of bg-modal to none
 * @param {*} id 
 */
function unsetDisplay(id) {
    var closeBtn = document.getElementsByClassName("modal-close")[0]

    closeBtn.addEventListener("click", function() {
        document.getElementsByClassName('bg-modal')[0].style.display = 'none'
        document.getElementsByClassName('top')[0].style.display = 'block'

        // moving to the part where i image was when clicked
        window.location.hash = id;
    })
    
}


/**
 * change the text in the close button from ^ to x
 * and from x tp ^
 */
function changeTextOnCloseBtn() {
    var closeBtn = document.getElementsByClassName("modal-close")[0]

    // when the mouse moves over the close button - hover
    closeBtn.addEventListener("mouseover", function() {
        closeBtn.textContent = "x"
    })

    // when the mouse moves away the close button - leave
    closeBtn.addEventListener("mouseleave", function() {
        closeBtn.textContent = "^"
    })
}
