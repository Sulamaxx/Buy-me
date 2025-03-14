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

        // Check if the banner should display on mobile based on each banner's `isMobileShow`
        if (this.shouldDisplayBanner(currentBanner)) {
            // Clear previous content and create a new image element
            const imgElement = document.createElement("img");
            imgElement.src = currentBanner.url;
            imgElement.alt = currentBanner.name || "Banner Description";
            imgElement.style.display = 'block';

            // Make the banner clickable only if a valid link is provided
            if (currentBanner.link && currentBanner.link !== '#' && currentBanner.link.trim() !== '') {
                imgElement.addEventListener("click", function() {
                    window.open(currentBanner.link, "_blank");
                });
                imgElement.style.cursor = "pointer"; // Indicate that it's clickable
            } else {
                imgElement.style.cursor = "default"; // Indicate non-clickable
            }

            imgElement.onerror = function() {
                console.error("Error loading banner image:", imgElement.src);
            };

            bannerContainer.innerHTML = "";
            bannerContainer.appendChild(imgElement);
        } else {
            // Clear the banner container if this banner's `isMobileShow` is 0 on mobile
            bannerContainer.innerHTML = "";
        }

        // Move to the next banner
        this.currentIndex = (this.currentIndex + 1) % this.banners.length;

        // Schedule the next rotation
        setTimeout(() => this.rotateBanner(), 8000);
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








