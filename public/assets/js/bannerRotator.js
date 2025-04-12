const BannerRotator = {
    banners: [],
    currentIndex: 0,

    addBanner: function(name, filename, link = '', isMobileShow = 1) {
        const url = "/public/uploads/" + filename;
        this.banners.push({ name, url, link, isMobileShow });
    },

    rotateBanner: function() {
        const bannerContainer = document.getElementById("bannerContainer");
    
        if (!this.banners.length) {
            console.error("No banners added to rotate.");
            return;
        }
    
        const currentBanner = this.banners[this.currentIndex];
    
        if (this.shouldDisplayBanner(currentBanner)) {
            bannerContainer.innerHTML = ""; // Clear previous content
    
            // Create the image element
            const imgElement = document.createElement("img");
            imgElement.src = currentBanner.url;
            imgElement.alt = currentBanner.name || "Banner Description";
            imgElement.style.display = 'block';
    
            // Create the button element
            /* const button = document.createElement('a');
            button.textContent = 'Check it out';
            button.href = currentBanner.link || '#'; // Use the banner's link, or '#' if no link
            button.className = 'btn btn-block border-null check-it-out-button';
            button.style.boxSizing = 'inherit';
            button.style.touchAction = 'manipulation';
        button.style.outline = '0';
        button.style.textDecoration = 'none';
        button.style.cursor = 'pointer';
        button.style.whiteSpace = 'nowrap';
        button.style.verticalAlign = 'middle';
        button.style.userSelect = 'none';
        button.style.transition = 'all .2s ease-in-out';
        button.style.display = 'block';
        button.style.borderRadius = '0px !important';
        button.style.width = '200px';
        button.style.margin = '0 auto';
        button.style.fontFamily = '"Roboto", Helvetica, Arial, sans-serif';
        button.style.fontWeight = 'bold';
        button.style.textTransform = 'none';
        button.style.textAlign = 'center';
        button.style.backgroundRepeat = 'repeat-x';
        button.style.backgroundColor = '#fff447';
        button.style.border = '1px solid #f6d80f';
        button.style.boxShadow = '0 1px 1px 0 #aaa';
        button.style.lineHeight = '17px';
        button.style.backgroundImage = 'linear-gradient(to bottom, #FE9000 0,#FE9000 100%)';
        button.style.borderColor = '#FE9000';
        button.style.position = 'absolute'; 
        button.style.bottom = '10px';    
        button.style.left = '10px';   
        button.style.zIndex = '10';      
        button.style.padding = '5px 3.75px !important'; 
        button.style.fontSize = '0.9em'; 
        button.style.color = '#000000 !important';  */
    
            // Make the image a link if a valid link is provided (image click opens link)
            if (currentBanner.link && currentBanner.link !== '#' && currentBanner.link.trim() !== '') {
                imgElement.style.cursor = "pointer";
                imgElement.addEventListener("click", function() {
                    window.open(currentBanner.link, "_blank");
                });
            } else {
                imgElement.style.cursor = "default";
            }
    
            imgElement.onerror = function() {
                console.error("Error loading banner image:", imgElement.src);
            };
    
            bannerContainer.style.position = 'relative'; // Make the container positioned
            bannerContainer.appendChild(imgElement);
            //bannerContainer.appendChild(button); // Append the button after the image
        } else {
            bannerContainer.innerHTML = "";
        }
    
        this.currentIndex = (this.currentIndex + 1) % this.banners.length;
        setTimeout(() => this.rotateBanner(), 5000);
    },

    startRotation: function() {
        this.rotateBanner();
    },

    shouldDisplayBanner: function(banner) {
        // Detect if the user is on a mobile device
        const isMobile = /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

        // Return true if on desktop or if banner's `isMobileShow` is 1
        return !isMobile || banner.isMobileShow === 1;
    }
};




// bannerRotator.js -v1.0
/*
const BannerRotator = {
    banners: [],
    currentIndex: 0,

    addBanner: function(url, link) {
        this.banners.push({ url, link });
    },

    rotateBanner: function() {
        const bannerContainer = document.getElementById("bannerContainer");
        const currentBanner = this.banners[this.currentIndex];

        const imgElement = document.createElement("img");
        imgElement.src = currentBanner.url;
        imgElement.alt = "Banner Description";

        imgElement.addEventListener("click", function() {
            window.open(currentBanner.link, "_blank");
        });

        bannerContainer.innerHTML = "";
        bannerContainer.appendChild(imgElement);

        this.currentIndex = (this.currentIndex + 1) % this.banners.length;

        setTimeout(() => BannerRotator.rotateBanner(), 8000);
    },

    startRotation: function() {
        this.rotateBanner();
    }
};



// bannerRotator.js - v1.1

const BannerRotator = {
    banners: [],
    currentIndex: 0,

    addBanner: function(filename, link) {
        const url = "/public/uploads/" + filename;
        this.banners.push({ url, link });
    },

    rotateBanner: function() {
        const bannerContainer = document.getElementById("bannerContainer");
        const currentBanner = this.banners[this.currentIndex];

        const imgElement = document.createElement("img");
        imgElement.src = currentBanner.url;
        imgElement.alt = "Banner Description";

        imgElement.addEventListener("click", function() {
            window.open(currentBanner.link, "_blank");
        });

        bannerContainer.innerHTML = "";
        bannerContainer.appendChild(imgElement);

        this.currentIndex = (this.currentIndex + 1) % this.banners.length;

        setTimeout(() => BannerRotator.rotateBanner(), 10000);
    },

    startRotation: function() {
        this.rotateBanner();
    }
};

*/

// bannerRotator.js - v1.3








