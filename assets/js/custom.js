//Developer: Rajesh Sahani Nov-2025

// Notification Start here...
document.querySelector(".marquee").addEventListener("mouseenter", function() {
    this.stop();
});

document.querySelector(".marquee").addEventListener("mouseleave", function() {
    this.start();
});

// Notification End here...

// Bell icon bounce start here...
setInterval(function() {
    const bellIcon = document.querySelector(".notification-box i");
    bellIcon.style.animation = "none";
    bellIcon.offsetHeight;
    bellIcon.style.animation = "bounce 1s ease-in-out";
}, 4000);

// Bell icon bounce end here...

// Increase/descrease font size start here...

// document.getElementById('increasetext').addEventListener('click', function () {
//   var increaseDecreasFnize = document.getElementById('increase-decreas-fn-size');
//   var curSize = parseInt(window.getComputedStyle(increaseDecreasFnize).fontSize) + 2;
//   if (curSize <= 32) {
//     increaseDecreasFnize.style.fontSize = curSize + 'px';
//   }
// });

// document.getElementById('resettext').addEventListener('click', function () {
//   var increaseDecreasFnize = document.getElementById('increase-decreas-fn-size');
//   var curSize = parseInt(window.getComputedStyle(increaseDecreasFnize).fontSize);
//   if (curSize !== 18) {
//     increaseDecreasFnize.style.fontSize = '18px';
//   }
// });

// document.getElementById('decreasetext').addEventListener('click', function () {
//   var increaseDecreasFnize = document.getElementById('increase-decreas-fn-size');
//   var curSize = parseInt(window.getComputedStyle(increaseDecreasFnize).fontSize) - 2;
//   if (curSize >= 14) {
//     increaseDecreasFnize.style.fontSize = curSize + 'px';
//   }
// });

document.addEventListener("DOMContentLoaded", function() {
    // Store the initial font sizes for multiple elements when the page loads
    var initialFontSize = {};

    // Get font size for each element individually and store the initial value
    ["p", "h1", "h2", "h3", "h4", "h5"].forEach(function(tag) {
        var elements = document.querySelectorAll(tag);
        elements.forEach(function(element) {
            if (element) {
                // Safely parse the font size and store it only if it's a valid number
                var fontSize = window.getComputedStyle(element).fontSize;
                var parsedFontSize = parseInt(fontSize, 10);
                if (!isNaN(parsedFontSize)) {
                    initialFontSize[tag] = parsedFontSize;
                }
            }
        });
    });

    // Function to change font size
    function change_size(tag, size) {
        // Make sure elements exist before calling getComputedStyle
        var element = document.querySelector(tag);
        if (!element) {
            console.error(`Element ${tag} not found.`);
            return;
        }

        var stepSize = 2; // Smaller step size
        var currentFontSize = parseInt(
            window.getComputedStyle(element).fontSize,
            10
        );

        if (isNaN(currentFontSize)) {
            console.error(`Invalid font size for element: ${tag}`);
            return;
        }

        var maxSize = initialFontSize[tag] + 4; // Limit to two steps bigger
        var minSize = initialFontSize[tag] - 4; // Limit to two steps smaller

        if (size === "smaller" && currentFontSize > minSize) {
            currentFontSize -= stepSize;
        } else if (size === "bigger" && currentFontSize < maxSize) {
            currentFontSize += stepSize;
        }

        var elements = document.querySelectorAll(tag);
        elements.forEach(function(el) {
            el.style.fontSize = currentFontSize + "px";
        });
    }

    // On 'Smaller' button click
    document
        .getElementById("Smaller")
        .addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default link behavior
            ["p", "h1", "h2", "h3", "h4", "h5"].forEach(function(tag) {
                change_size(tag, "smaller");
            });
        });

    // On 'Bigger' button click
    document.getElementById("Bigger").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default link behavior
        ["p", "h1", "h2", "h3", "h4", "h5"].forEach(function(tag) {
            change_size(tag, "bigger");
        });
    });

    // On 'Reset' button click
    document.getElementById("Reset").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default link behavior
        // Reset font size for all elements to their initial size
        ["p", "h1", "h2", "h3", "h4", "h5"].forEach(function(tag) {
            var elements = document.querySelectorAll(tag);
            elements.forEach(function(elm) {
                // Check if the initial font size is valid before applying
                if (initialFontSize[tag]) {
                    elm.style.fontSize = initialFontSize[tag] + "px";
                }
            });
        });
    });
});

function toggleShare() {
    document.querySelector(".share-wrapper").classList.toggle("active");
}

const pageUrl = encodeURIComponent(window.location.href);
const pageTitle = encodeURIComponent(document.title);

// Twitter (X)
function shareTwitter() {
    window.open(
        `https://twitter.com/intent/tweet?url=${"https://x.com/CSCegov_"}&text=${"CSCeGOV"}`,
        "_blank"
    );
}

// Facebook
function shareFacebook() {
    window.open(
        `https://www.facebook.com/sharer/sharer.php?u=${"https://www.facebook.com/cscscheme"}`,
        "_blank"
    );
}

// LinkedIn
function shareLinkedIn() {
    window.open(
        `https://www.linkedin.com/company/common-services-centers-official/posts/?feedView=all${pageUrl}`,
        "_blank"
    );
}

// WhatsApp
function shareWhatsApp() {
    window.open(
        `https://www.whatsapp.com/channel/0029Va5pY1EJpe8avzCDsy2f`,
        "_blank"
    );
}

// YouTube
function shareYoutube() {
    window.open("https://www.youtube.com/user/CSCSCHEME", "_blank");
}

// Instagram
function shareInstagram() {
    window.open("https://www.instagram.com/commonservicescenters/", "_blank");
}
var img_path = 'https://digitalseva.csc.gov.in/assets/images/state-logo/';
const statesData = {
    "Andhra Pradesh": {
        image: img_path + "Andhra-Pradesh.svg",
        heading: "Andhra Pradesh",
        description: "Explore the key services available in Andhra Pradesh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "Andhra Pradesh RTA Services",
            },
            {
                sno: "2",
                service: "Digital Police Services Andhra Pradesh CCTNS",
            },
        ],
    },

    "Arunachal Pradesh": {
        image: img_path + "Arunachal-Pradesh.svg",
        heading: "Arunachal Pradesh",
        description: "Explore the key services available in Arunachal Pradesh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Bharat Bill Payment System",
                sno2: "2",
                service2: "CIBIL",
            },
            {
                sno1: "3",
                service1: "CPGRAMS",
                sno2: "4",
                service2: "CSC Academy"
            },
            {
                sno1: "5",
                service1: "Educational Service",
                sno2: "6",
                service2: "E-Recharge",
            },
            {
                sno1: "7",
                service1: "Estamp",
                sno2: "8",
                service2: "Insurance"
            },
            {
                sno1: "9",
                service1: "IT Return Filing",
                sno2: "10",
                service2: "PAN Services",
            },
            {
                sno1: "11",
                service1: "Passport Services",
                sno2: "12",
                service2: "Pension Services",
            },
            {
                sno1: "13",
                service1: "PM Fasal Bima Yojana",
                sno2: "14",
                service2: "PM-Kissan",
            },
            {
                sno1: "15",
                service1: "Tours And Travels",
                sno2: "16",
                service2: "UCL Demographic Update",
            },
            {
                sno1: "17",
                service1: "Udyam Parichay",
                sno2: "",
                service2: ""
            },
        ],
    },

    Assam: {
        image: img_path + "Assam.svg",
        heading: "Assam",
        description: "Explore the key services available in Assam.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District",
            },
            {
                sno: "2",
                service: "Municipal",
            },
            {
                sno: "3",
                service: "Centralized Farmer Registration Assam",
            },
        ],
    },

    Bihar: {
        image: img_path + "Bihar.svg",
        heading: "Bihar",
        description: "Explore the key services available in Bihar.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District",
            },
            {
                sno: "2",
                service: "Municipal",
            },
            {
                sno: "3",
                service: "Bihar Rajya Fasal Sahayata Yojna",
            },
            {
                sno: "4",
                service: "Land And Revenue Dept Bihar Govt",
            },
            {
                sno: "5",
                service: "eLabharthi Service",
            },
            {
                sno: "6",
                service: "BOCW Labour",
            },
        ],
    },

    Chhattisgarh: {
        image: img_path + "Chhattisgarh.svg",
        heading: "Chhattisgarh",
        description: "Explore the key services available in Chhattisgarh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District",
            },
            {
                sno: "2",
                service: "Municipal",
            },
            {
                sno: "3",
                service: "Centralized Farmer Registration - CG",
            },
            {
                sno: "4",
                service: "BOCW Labour",
            },
        ],
    },
    Goa: {
        image: img_path + "Goa.svg",
        heading: "Goa",
        description: "Explore the key services available in Goa.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
        ],
    },

    Gujarat: {
        image: img_path + "Gujarat.svg",
        heading: "Gujarat",
        description: "Explore the key services available in Gujarat.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "Centralized Farmer Registration - Gujarat"
            },
            {
                sno: "2",
                service: "BOCW Labour"
            },
        ],
    },

    Haryana: {
        image: img_path + "Haryana.svg",
        heading: "Haryana",
        description: "Explore the key services available in Haryana.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "BOCW Labour"
            },
        ],
    },

    "Himachal Pradesh": {
        image: img_path + "Himachal-Pradesh.svg",
        heading: "Himachal Pradesh",
        description: "Explore the key services available in Himachal Pradesh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "Himcare"
            },
            {
                sno: "4",
                service: "e-Licence Fisheries - Himachal Pradesh"
            },
        ],
    },

    Jharkhand: {
        image: img_path + "Jharkhand.svg",
        heading: "Jharkhand",
        description: "Explore the key services available in Jharkhand.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "Registration For Krishi Reen Maafi Yojna"
            },
            {
                sno: "4",
                service: "Jharkhand State Food Commission"
            },
            {
                sno: "5",
                service: "Kisan Samriddhi Yojna"
            },
            {
                sno: "6",
                service: "CM Fellowship Scheme Manki Munda Scheme - Jharkhand",
            },
        ],
    },

    Karnataka: {
        image: img_path + "Karnataka.svg",
        heading: "Karnataka",
        description: "Explore the key services available in Karnataka.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "Karnataka Public Service Commission"
            },
            {
                sno: "2",
                service: "e-Prasada Services"
            },
        ],
    },

    Keralaa: {
        image: img_path + "Kerala.svg",
        heading: "Kerala",
        description: "Explore the key services available in Kerala.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Bharat Bill Payment System",
                sno2: "2",
                service2: "CIBIL",
            },
            {
                sno1: "3",
                service1: "CPGRAMS",
                sno2: "4",
                service2: "Crop Healthcare",
            },
            {
                sno1: "5",
                service1: "CSC Academy",
                sno2: "6",
                service2: "CSC Dhwani"
            },
            {
                sno1: "7",
                service1: "Diginame.in",
                sno2: "8",
                service2: "E-Courts"
            },
            {
                sno1: "9",
                service1: "Educational Service",
                sno2: "10",
                service2: "E-Recharge",
            },
            {
                sno1: "11",
                service1: "E-Sign",
                sno2: "12",
                service2: "Fastag"
            },
            {
                sno1: "13",
                service1: "PM-Ujjwala",
                sno2: "14",
                service2: "Health Care Services",
            },
            {
                sno1: "15",
                service1: "Insurance",
                sno2: "16",
                service2: "IT Return Filing",
            },
            {
                sno1: "17",
                service1: "Jeevan Pramaan",
                sno2: "18",
                service2: "Loan EMI Collection",
            },
            {
                sno1: "19",
                service1: "National Scholarship Portal",
                sno2: "20",
                service2: "State G2C Services",
            },
            {
                sno1: "21",
                service1: "PAN Services",
                sno2: "22",
                service2: "Passport Services",
            },
            {
                sno1: "23",
                service1: "Pension Services",
                sno2: "24",
                service2: "PM Fasal Bima Yojana",
            },
            {
                sno1: "25",
                service1: "PM-Kissan",
                sno2: "26",
                service2: "PMSYM"
            },
            {
                sno1: "27",
                service1: "Recruitment Service",
                sno2: "28",
                service2: "Registration For LPG Distribution Point",
            },
            {
                sno1: "29",
                service1: "Skill Development",
                sno2: "30",
                service2: "Tours And Travels",
            },
            {
                sno1: "31",
                service1: "UCL Demographic Update",
                sno2: "32",
                service2: "Udyam Parichay",
            },
        ],
    },

    "Madhya Pradesh": {
        image: img_path + "Madhya-Pradesh.svg",
        heading: "Madhya Pradesh",
        description: "Explore the key services available in Madhya Pradesh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "Centralized Farmer Registration - MP"
            },
            {
                sno: "4",
                service: "Sambal 2.0"
            },
        ],
    },

    Maharashtra: {
        image: img_path + "Maharashtra.svg",
        heading: "Maharashtra",
        description: "Explore the key services available in Maharashtra.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "Centralized Farmer Registration - MH"
            },
        ],
    },

    Manipurr: {
        image: img_path + "Manipur.svg",
        heading: "Manipur",
        description: "Explore the key services available in Manipur.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Agriculture Service",
                sno2: "2",
                service2: "Bharat Bill Payment System",
            },
            {
                sno1: "3",
                service1: "Cpgrams",
                sno2: "4",
                service2: "Csc Academy"
            },
            {
                sno1: "5",
                service1: "Educational Service",
                sno2: "6",
                service2: "E-Recharge",
            },
            {
                sno1: "7",
                service1: "Estamp",
                sno2: "8",
                service2: "Pm-Ujjwala"
            },
            {
                sno1: "9",
                service1: "Insurance",
                sno2: "10",
                service2: "It Return Filing",
            },
            {
                sno1: "11",
                service1: "National Scholarship Portal",
                sno2: "12",
                service2: "State G2C Services",
            },
            {
                sno1: "13",
                service1: "Pan Services",
                sno2: "14",
                service2: "Passport Services",
            },
            {
                sno1: "15",
                service1: "Pension Services",
                sno2: "16",
                service2: "Pm Fasal Bima Yojana",
            },
            {
                sno1: "17",
                service1: "Pm-Kissan",
                sno2: "18",
                service2: "Pmsym"
            },
            {
                sno1: "19",
                service1: "Recruitment Service",
                sno2: "20",
                service2: "Skill Development",
            },
            {
                sno1: "21",
                service1: "Tours And Travels",
                sno2: "22",
                service2: "Udyam Parichay",
            },
            {
                sno1: "23",
                service1: "Registration For LPG Distribution Point",
                sno2: "",
                service2: "",
            },
        ],
    },

    Meghalayaa: {
        image: img_path + "Meghalaya.svg",
        heading: "Meghalaya",
        description: "Explore the key services available in Meghalaya.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Agriculture Service",
                sno2: "2",
                service2: "Bharat Bill Payment System",
            },
            {
                sno1: "3",
                service1: "Cibil",
                sno2: "4",
                service2: "Cpgrams"
            },
            {
                sno1: "5",
                service1: "Crop Healthcare",
                sno2: "6",
                service2: "Csc Academy",
            },
            {
                sno1: "7",
                service1: "E-Courts",
                sno2: "8",
                service2: "Educational Service",
            },
            {
                sno1: "9",
                service1: "E-Recharge",
                sno2: "10",
                service2: "Estamp"
            },
            {
                sno1: "11",
                service1: "E-Sign",
                sno2: "12",
                service2: "Fastag"
            },
            {
                sno1: "13",
                service1: "Pm-Ujjwala",
                sno2: "14",
                service2: "Health Care Services",
            },
            {
                sno1: "15",
                service1: "Insurance",
                sno2: "16",
                service2: "IT Return Filing",
            },
            {
                sno1: "17",
                service1: "Jeevan Pramaan",
                sno2: "18",
                service2: "Loan EMI Collection",
            },
            {
                sno1: "19",
                service1: "National Scholarship Portal",
                sno2: "20",
                service2: "Pan Services",
            },
            {
                sno1: "21",
                service1: "Passport Services",
                sno2: "22",
                service2: "Pension Services",
            },
            {
                sno1: "23",
                service1: "Pm Fasal Bima Yojana",
                sno2: "24",
                service2: "Pm-Kissan",
            },
            {
                sno1: "25",
                service1: "Recruitment Service",
                sno2: "26",
                service2: "Tours And Travels",
            },
            {
                sno1: "27",
                service1: "Udyam Parichay",
                sno2: "28",
                service2: "Registration For LPG Distribution Point",
            },
            {
                sno1: "29",
                service1: "Skill Development",
                sno2: "30",
                service2: "Tours And Travels",
            },
            {
                sno1: "31",
                service1: "UCL Demographic Update",
                sno2: "",
                service2: "",
            },
        ],
    },

    Mizoramm: {
        image: img_path + "Mizoram.svg",
        heading: "Mizoram",
        description: "Explore the key services available in Mizoram.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Agriculture Service",
                sno2: "2",
                service2: "Bharat Bill Payment System",
            },
            {
                sno1: "3",
                service1: "Cpgrams",
                sno2: "4",
                service2: "Crop Healthcare",
            },
            {
                sno1: "5",
                service1: "E-Courts",
                sno2: "6",
                service2: "E-Recharge"
            },
            {
                sno1: "7",
                service1: "Health Care Services",
                sno2: "8",
                service2: "Insurance",
            },
            {
                sno1: "9",
                service1: "IT Return Filing",
                sno2: "10",
                service2: "Jeevan Pramaan",
            },
            {
                sno1: "11",
                service1: "Loan Emi Collection",
                sno2: "12",
                service2: "National Scholarship Portal",
            },
            {
                sno1: "13",
                service1: "Pan Services",
                sno2: "14",
                service2: "Passport Services",
            },
            {
                sno1: "15",
                service1: "Pension Services",
                sno2: "16",
                service2: "Pm-Kissan",
            },
            {
                sno1: "17",
                service1: "Recruitment Service",
                sno2: "18",
                service2: "Tours And Travels",
            },
            {
                sno1: "19",
                service1: "Udyam Parichay",
                sno2: "",
                service2: ""
            },
        ],
    },

    Nagalandd: {
        image: img_path + "Nagaland.svg",
        heading: "Nagaland",
        description: "Explore the key services available in Nagaland.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Bharat Bill Payment System",
                sno2: "2",
                service2: "Crop Healthcare",
            },
            {
                sno1: "3",
                service1: "Csc Academy",
                sno2: "4",
                service2: "Educational Service",
            },
            {
                sno1: "5",
                service1: "E-Recharge",
                sno2: "6",
                service2: "Pm-Ujjwala"
            },
            {
                sno1: "7",
                service1: "Health Care Services",
                sno2: "8",
                service2: "Insurance",
            },
            {
                sno1: "9",
                service1: "It Return Filing",
                sno2: "10",
                service2: "National Scholarship Portal",
            },
            {
                sno1: "11",
                service1: "Pan Services",
                sno2: "12",
                service2: "Passport Services",
            },
            {
                sno1: "13",
                service1: "Pm-Kissan",
                sno2: "14",
                service2: "Pmsym"
            },
            {
                sno1: "15",
                service1: "Recruitment Service",
                sno2: "16",
                service2: "Tours And Travels",
            },
            {
                sno1: "17",
                service1: "Ucl Demographic Update",
                sno2: "18",
                service2: "Udyam Parichay",
            },
        ],
    },

    Odisha: {
        image: img_path + "Odisha.svg",
        heading: "Odisha",
        description: "Explore the key services available in Odisha.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
            sno: "1",
            service: "Centralized Farmer Registration - Odisha"
        }],
    },
    Punjab: {
        image: img_path + "Punjab.svg",
        heading: "Punjab",
        description: "Explore the key services available in Punjab.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
            sno: "1",
            service: "BOCW Labour"
        }],
    },

    Rajasthan: {
        image: img_path + "Rajasthan.svg",
        heading: "Rajasthan",
        description: "Explore the key services available in Rajasthan.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "Digital Police Services Rajasthan CCTNS"
            },
            {
                sno: "2",
                service: "Centralized Farmer Registration - Rajasthan"
            },
        ],
    },

    Sikkim: {
        image: img_path + "Sikkim.svg",
        heading: "Sikkim",
        description: "Explore the key services available in Sikkim.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
            sno: "1",
            service: "Sikkim Transport - Sarathi Services"
        }],
    },

    "Tamil Nadu": {
        image: img_path + "Tamil-Nadu.svg",
        heading: "Tamil Nadu",
        description: "Explore the key services available in Tamil Nadu.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
            sno: "1",
            service: "Centralized Farmer Registration - TN"
        }],
    },

    Telanganaa: {
        image: img_path + "Telangana.svg",
        heading: "Telangana",
        description: "Explore the key services available in Telangana.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Bharat Bill Payment System",
                sno2: "2",
                service2: "Cibil",
            },
            {
                sno1: "3",
                service1: "Cpgrams",
                sno2: "4",
                service2: "Crop Healthcare",
            },
            {
                sno1: "5",
                service1: "Csc Academy",
                sno2: "6",
                service2: "Educational Service",
            },
            {
                sno1: "7",
                service1: "Electricity Bill Payment",
                sno2: "8",
                service2: "E-Recharge",
            },
            {
                sno1: "9",
                service1: "E-Sign",
                sno2: "10",
                service2: "Fastag"
            },
            {
                sno1: "11",
                service1: "Pm-Ujjwala",
                sno2: "12",
                service2: "Health Care Services",
            },
            {
                sno1: "13",
                service1: "Insurance",
                sno2: "14",
                service2: "It Return Filing",
            },
            {
                sno1: "15",
                service1: "Jeevan Pramaan",
                sno2: "16",
                service2: "Loan Emi Collection",
            },
            {
                sno1: "17",
                service1: "National Scholarship Portal",
                sno2: "18",
                service2: "State G2C Services",
            },
            {
                sno1: "19",
                service1: "Pan Services",
                sno2: "20",
                service2: "Passport Services",
            },
            {
                sno1: "21",
                service1: "Pension Services",
                sno2: "22",
                service2: "Pm Fasal Bima Yojana",
            },
            {
                sno1: "23",
                service1: "Pm-Kissan",
                sno2: "24",
                service2: "Pmkmy"
            },
            {
                sno1: "25",
                service1: "Pmsym",
                sno2: "26",
                service2: "Recruitment Service",
            },
            {
                sno1: "27",
                service1: "Registration For Lpg Distribution Point",
                sno2: "28",
                service2: "Skill Development",
            },
            {
                sno1: "29",
                service1: "Tours And Travels",
                sno2: "30",
                service2: "Ucl Demographic Update",
            },
            {
                sno1: "31",
                service1: "Udyam Parichay",
                sno2: "",
                service2: ""
            },
        ],
    },

    Tripura: {
        image: img_path + "Tripura.webp",
        heading: "Tripura",
        description: "Explore the key services available in Tripura.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "1",
                service: "Municipal"
            },
            {
                sno: "2",
                service: "BOCW Labour"
            },
        ],
    },

    "Uttar Pradesh": {
        image: img_path + "Uttar-Pradesh.svg",
        heading: "Uttar Pradesh",
        description: "Explore the key services available in Uttar Pradesh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "Centralized Farmer Registration -UP"
            },
            {
                sno: "4",
                service: "BOCW Labour"
            },
        ],
    },

    Uttarakhand: {
        image: img_path + "Uttarakhand.svg",
        heading: "Uttarakhand",
        description: "Explore the key services available in Uttarakhand.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
            {
                sno: "3",
                service: "EVAHAN UK"
            },
            {
                sno: "4",
                service: "e-Sarthi UK"
            },
            {
                sno: "5",
                service: "Uttarakhand Awas Evam Vikash Parishad"
            },
            {
                sno: "6",
                service: "BOCW Labour"
            },
        ],
    },

    "West Bengall": {
        image: img_path + "West-Bengal.svg",
        heading: "West Bengal",
        description: "Explore the key services available in West Bengal.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Agriculture Service",
                sno2: "2",
                service2: "Bharat Bill Payment System",
            },
            {
                sno1: "3",
                service1: "Cibil",
                sno2: "4",
                service2: "Cpgrams"
            },
            {
                sno1: "5",
                service1: "Crop Healthcare",
                sno2: "6",
                service2: "Csc Academy",
            },
            {
                sno1: "7",
                service1: "Csc Dhwani",
                sno2: "8",
                service2: "Diginame.In"
            },
            {
                sno1: "9",
                service1: "E-Courts",
                sno2: "10",
                service2: "Educational Service",
            },
            {
                sno1: "11",
                service1: "E-Recharge",
                sno2: "12",
                service2: "E-Sign"
            },
            {
                sno1: "13",
                service1: "Fastag",
                sno2: "14",
                service2: "Pm-Ujjwala"
            },
            {
                sno1: "15",
                service1: "Health Care Services",
                sno2: "16",
                service2: "Insurance",
            },
            {
                sno1: "17",
                service1: "It Return Filing",
                sno2: "18",
                service2: "Jeevan Pramaan",
            },
            {
                sno1: "19",
                service1: "Loan Emi Collection",
                sno2: "20",
                service2: "National Scholarship Portal",
            },
            {
                sno1: "21",
                service1: "State G2C Services",
                sno2: "22",
                service2: "Pan Services",
            },
            {
                sno1: "23",
                service1: "Passport Services",
                sno2: "24",
                service2: "Pension Services",
            },
            {
                sno1: "25",
                service1: "Pm Fasal Bima Yojana",
                sno2: "26",
                service2: "Pm-Kissan",
            },
            {
                sno1: "27",
                service1: "Pmkmy",
                sno2: "28",
                service2: "Pmsym"
            },
            {
                sno1: "29",
                service1: "Recruitment Service",
                sno2: "30",
                service2: "Registration For Lpg Distribution Point",
            },
            {
                sno1: "31",
                service1: "Skill Development",
                sno2: "32",
                service2: "Tours And Travels",
            },
            {
                sno1: "33",
                service1: "Ucl Demographic Update",
                sno2: "34",
                service2: "Udyam Parichay",
            },
            {
                sno1: "35",
                service1: "Water Bill Payment",
                sno2: "",
                service2: ""
            },
        ],
    },

    // ================= UNION TERRITORIES =================
    "Andaman and Nicobar Islandss": {
        image: img_path + "Andaman-and-Nicobar.svg",
        heading: "Andaman and Nicobar Islands",
        description: "Explore the key services available in Andaman and Nicobar Islands.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Tourism Andaman",
                sno2: "2",
                service2: "e-District",
            },
            {
                sno1: "3",
                service1: "Bharat Bill Payment System",
                sno2: "4",
                service2: "Cibil",
            },
            {
                sno1: "5",
                service1: "Electricity Bill Payment",
                sno2: "6",
                service2: "E-Recharge",
            },
            {
                sno1: "7",
                service1: "Insurance",
                sno2: "8",
                service2: "IT Return Filing",
            },
            {
                sno1: "9",
                service1: "Pan Services",
                sno2: "10",
                service2: "Passport Services",
            },
            {
                sno1: "11",
                service1: "Pension Services",
                sno2: "12",
                service2: "Tours And Travels",
            },
        ],
    },

    Chandigarhh: {
        image: img_path + "Chandigarh.svg",
        heading: "Chandigarh",
        description: "Explore the key services available in Chandigarh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Bharat Bill Payment System",
                sno2: "2",
                service2: "CIBIL",
            },
            {
                sno1: "3",
                service1: "E-Recharge",
                sno2: "4",
                service2: "PM-Ujjwala"
            },
            {
                sno1: "5",
                service1: "Insurance",
                sno2: "6",
                service2: "IT Return Filing",
            },
            {
                sno1: "7",
                service1: "PAN Services",
                sno2: "8",
                service2: "Passport Services",
            },
            {
                sno1: "9",
                service1: "Pension Services",
                sno2: "10",
                service2: "Tours And Travels",
            },
            {
                sno1: "11",
                service1: "UCL Demographic Update",
                sno2: "",
                service2: "",
            },
        ],
    },

    "Dadra and Nagar Haveli and Daman and Diu": {
        image: img_path + "Dadra-and-Nagar-Haveli-and-Daman-and-Diu.svg",
        heading: "Dadra & Nagar Haveli and Daman & Diu",
        description: "Explore the key services available in Dadra and Nagar Haveli & Daman and Diu.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District",
            },
            {
                sno: "2",
                service: "Municipal",
            },
        ],
    },

    Delhi: {
        image: img_path + "Delhi.svg",
        heading: "Delhi",
        description: "Explore the key services available in Delhi.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
        ],
    },

    "Jammu and Kashmir": {
        image: img_path + "Jammu-and-Kashmir.svg",
        heading: "Jammu and Kashmir",
        description: "Explore the key services available in Jammu and Kashmir.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "1",
                service: "Municipal"
            },
            {
                sno: "2",
                service: "EVAHAN Jammu & Kashmir"
            },
            {
                sno: "3",
                service: "Jakega-E-Unnat"
            },
            {
                sno: "4",
                service: "Kisan Sathi"
            },
        ],
    },
    Ladakh: {
        image: img_path + "Ladakh.svg",
        heading: "Ladakh",
        description: "Explore the key services available in Ladakh.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
            sno: "1",
            service: "E-Sarathi Ladakh"
        }],
    },

    Lakshadweepp: {
        image: img_path + "Lakshadweep.svg",
        heading: "Lakshadweep",
        description: "Explore the key services available in Lakshadweep.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
            {
                key: "sno2",
                label: "Sno."
            },
            {
                key: "service2",
                label: "Service Name"
            },
        ],
        table: [{
                sno1: "1",
                service1: "Bharat Bill Payment System",
                sno2: "2",
                service2: "E-Recharge",
            },
            {
                sno1: "3",
                service1: "Insurance",
                sno2: "4",
                service2: "IT Return Filing",
            },
            {
                sno1: "5",
                service1: "PAN Services",
                sno2: "6",
                service2: "Passport Services",
            },
            {
                sno1: "7",
                service1: "Tours And Travels",
                sno2: "8",
                service2: "Udyam Parichay",
            },
        ],
    },

    Puducherry: {
        image: img_path + "Puducherry.svg",
        heading: "Puducherry",
        description: "Explore the key services available in Puducherry.",
        tableHeaders: [{
                key: "sno",
                label: "Sno."
            },
            {
                key: "service",
                label: "Service Name"
            },
        ],
        table: [{
                sno: "1",
                service: "e-District"
            },
            {
                sno: "2",
                service: "Municipal"
            },
        ],
    },
};

function openStateModal(stateName) {
    const state = statesData[stateName];

    document.getElementById("stateHeading").innerText = state.heading;

    // document.getElementById("stateHeading").innerText = state.heading;
    document.getElementById("stateImage").src = state.image;

    // document.getElementById("stateDescription").innerText =
    //   state.description || "";
    // Build table head dynamically
    const thead = document.getElementById("stateTableHead");
    thead.innerHTML = `
    <tr>
      ${state.tableHeaders.map((h) => `<th>${h.label}</th>`).join("")}
    </tr>
  `;

    // Build table body dynamically using the keys
    const tbody = document.getElementById("stateTableBody");
    tbody.innerHTML = "";
    state.table.forEach((row) => {
        tbody.innerHTML += `
      <tr>
        ${state.tableHeaders.map((h) => `<td>${row[h.key]}</td>`).join("")}
      </tr>
    `;
    });

    new bootstrap.Modal(document.getElementById("stateModal")).show();
}