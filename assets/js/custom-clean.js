// CHANDAN CYBER ZONE - Clean Custom JS (2025)
// Core functionality only: notifications, animations, shares

document.addEventListener("DOMContentLoaded", function() {
    // Marquee pause/resume
    const marquee = document.querySelector(".marquee");
    if (marquee) {
        marquee.addEventListener("mouseenter", function() { this.stop(); });
        marquee.addEventListener("mouseleave", function() { this.start(); });
    }

    // Bell bounce animation
    setInterval(function() {
        const bellIcon = document.querySelector(".notification-box i");
        if (bellIcon) {
            bellIcon.style.animation = "none";
            bellIcon.offsetHeight; // Trigger reflow
            bellIcon.style.animation = "bounce 1s ease-in-out";
        }
    }, 4000);

    // Social shares (customize URLs if needed)
    const pageUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent(document.title);

    window.shareTwitter = () => window.open(`https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`, "_blank");
    window.shareFacebook = () => window.open(`https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`, "_blank");
    window.shareLinkedIn = () => window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`, "_blank");
    window.shareWhatsApp = () => window.open(`https://wa.me/?text=${pageTitle}%20${pageUrl}`, "_blank");
    window.shareYoutube = () => window.open("https://www.youtube.com/user/CSCSCHEME", "_blank");
    window.shareInstagram = () => window.open("https://www.instagram.com/commonservicescenters/", "_blank");
});

