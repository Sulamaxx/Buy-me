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








