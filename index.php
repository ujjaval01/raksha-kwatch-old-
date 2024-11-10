<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raksha Kwatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            text-align: center;
        }
        h1, h2, h3, p, .card-title, .card-text {
            transition: all 0.3s ease;
        }
        .title-banner {
            background-color: #343a40;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            position: relative;
        }
        .portal-card {
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            border: 1px solid #dee2e6;
            border-radius: 15px;
        }
        .portal-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }
        .future-scope {
            background-color: #e9ecef;
            padding: 40px;
            border-radius: 15px;
            margin-top: 30px;
        }
        /* .image-container {
            width: 100%;
            height: 400px;
            overflow: hidden;
            position: relative;
            border-radius: 15px;
            margin-top: 20px;
            transition: transform .2s;
        }
        .image-container img {
            width: 100vw;
            height: 100%;
            object-fit: cover;
            object-position: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        } */
     
        .btn-primary, .btn-success, .btn-danger {
            border-radius: 20px;
        }
        .language-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .language-btn:hover {
            background-color: #0056b3;
        }

        /* added more */
    
    /* added more end */
       
    /* Sliding Cards Styles */
    .sliding-cards {
      display: flex;
      overflow-x: hidden; /* Hide scrollbar */
      scroll-behavior: smooth;
      padding: 20px;
      margin: 20px 0;
      white-space: nowrap; /* Keep images in a single row */
    }

    .sliding-cards img {
      display: inline-block;
      width: 200px;
      height: 150px;
      object-fit: cover; /* Ensures images are cropped to fit */
      border-radius: 8px;
      margin-right: 10px;
      transition: transform 0.2s;
    }

    /* Image zoom effect on hover */
    .sliding-cards img:hover {
      transform: scale(1.1);
    }
  
    .scroll-text {
      white-space: nowrap;
      overflow: hidden;
      box-sizing: border-box;
    }

    .scroll-text span {
      display: inline-block;
      padding-left: 100%;
      animation: scroll 15s linear infinite;
      font-size: 24px; /* Increase the font size */
    }

    @keyframes scroll {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }

    /* upper sliding images */

    .sliding-card-container {
      width: 1000px;
      max-width: 1010px;
      height: 367px;
      overflow: hidden;
      position: relative;
      border-radius: 15px;
      margin: 20px auto;
    }
    .sliding-card {
      transition: transform 0.5s ease-in-out;
      white-space: nowrap;
    }

    .sliding-card img {
      width: 990px;
      height: 367px;
      object-fit:fill;
      border-radius: 35px;
      transition: transform 0.5s ease;
    }
    .sliding-card img:hover {
      transform: scale(1.1);
    }

    /* Dots for current slide indicator */
    .slider-dots {
      position: absolute;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 10px;
    }

    .slider-dots .dot {
      width: 12px;
      height: 12px;
      background-color: #bbb;
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .slider-dots .dot.active {
      background-color: #333;
    }


    </style>
</head>
<body>

<!-- Language Button -->
<button class="language-btn" onclick="toggleLanguage()" id="languageButton">हिन्दी</button>

<div class="container">
    <div class="title-banner">
    <h1 id="title">Protection Shield (रक्षा कवच)</h1>
<div class="scroll-text">
    <span id="subtitle">A Web Based Real-time Reporting or Guardian Alerts Women Safety & Security System Application</span>
</div>
        <!-- <marquee id="subtitle" behavior="scroll" direction="left">A Web Based Real-time Reporting or Guardian Alerts Women Safety & Security System Application</marquee>> -->
        <!-- <h2 id="subtitle">A Web Based Real-time Reporting or Guardian Alerts Women Safety & Security System Application</h2> -->
    </div>
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card portal-card">
                <div class="card-body">
                    <h5 class="card-title" id="adminTitle">Admin Portal</h5>
                    <p class="card-text" id="adminText">Manage the entire application and user complaints.</p>
                    <a href="admin/admin_login.php" class="btn btn-primary" id="adminBtn">Access Admin</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card portal-card">
                <div class="card-body">
                    <h5 class="card-title" id="userTitle">User Portal</h5>
                    <p class="card-text" id="userText">Submit complaints and manage your profile.</p>
                    <a href="user/login.php" class="btn btn-success" id="userBtn">Access User</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card portal-card">
                <div class="card-body">
                    <h5 class="card-title" id="policeTitle">Police Portal</h5>
                    <p class="card-text" id="policeText">Review complaints and take necessary actions.</p>
                    <a href="police/register_police.php" class="btn btn-danger" id="policeBtn">Access Police</a>
                </div>
            </div>
        </div>
    </div>

    <div class="sliding-card-container">
    <div class="sliding-card" id="slidingCard">
      <img src="./images/womens-safety.jpg" alt="Image 1">
      <img src="./images/women-safety5.png" alt="Image 5">
      <img src="./images/women-safety4.jpg" alt="Image 4">
      <img src="./images/womens-safety.jpg" alt="Image 1">
      <img src="./images/womens-safety.jpg" alt="Image 1">
      <img src="./images/womens-safety.jpg" alt="Image 1">
      <img src="./images/women-safety3.jpeg" alt="Image 3">
      <img src="./images/women-safety2.jpg" alt="Image 2">
    </div>
    <div class="slider-dots" id="sliderDots"></div>
  </div>



    <br>
    <h2 id="aboutTitle">About the Application</h2>
    <p id="aboutText">The Women Safety System is designed to empower women by providing them with a secure platform to submit complaints and manage their safety. It connects users with the relevant authorities, ensuring timely responses to incidents.</p>
    
    <div class="future-scope">
        <h3 id="futureScopeTitle">Future Scope</h3>
        <p id="futureScopeText">In the future, we plan to enhance the application by integrating:</p>
        <ul>
            <li id="futureScopeText1">Real-time GPS tracking for emergency situations</li>
            <li id="futureScopeText2">Chatbot support for instant assistance</li>
            <li id="futureScopeText3">Integration with local law enforcement databases</li>
            <li id="futureScopeText4">Mobile app development for better accessibility</li>
        </ul>
    </div>
</div>

<div class="sliding-cards" id="slidingCards">
    <img src="images/admin.png" alt="Image 1">
    <img src="images/admin_login.jpg" alt="Image 2">
    <img src="images/desktop.jpg" alt="Image 3">
    <img src="images/GettyImages.jpg" alt="Image 4">
    <img src="images/panic.jpg" alt="Image 5">
    <img src="images/user_reg.jpg" alt="Image 6">
    <img src="images/image3.webp" alt="Image 7">
    <img src="images/images (1).png" alt="Image 8">
  </div>


<footer>
    <div class="container text-center">
        <p>&copy; 2024 Women Safety System. All Rights Reserved.</p>
        <p>Developed by: Ujjaval Saini</p>
        <p>Contact: sainiujvl@gmail.com</p>
        <a href="about.php">About the Application or Developer</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let isHindi = false;

    const content = {
        english: {
            title: "Protection Shield (रक्षा कवच)",
            subtitle: "A Web Based Real-time Reporting or Guardian Alerts Women Safety & Security System Application",
            adminTitle: "Admin Portal",
            adminText: "Manage the entire application and user complaints.",
            adminBtn: "Access Admin",
            userTitle: "User Portal",
            userText: "Submit complaints and manage your profile.",
            userBtn: "Access User",
            policeTitle: "Police Portal",
            policeText: "Review complaints and take necessary actions.",
            policeBtn: "Access Police",
            aboutTitle: "About the Application",
            aboutText: "The Women Safety System is designed to empower women by providing them with a secure platform to submit complaints and manage their safety. It connects users with the relevant authorities, ensuring timely responses to incidents.",
            futureScopeTitle: "Future Scope",
            futureScopeText: "In the future, we plan to enhance the application by integrating:",
            futureScopeText1: "Real-time GPS tracking for emergency situations",
            futureScopeText2:"Chatbot support for instant assistance",
            futureScopeText3:"Integration with local law enforcement databases",
            futureScopeText4:"Mobile app development for better accessibility"

        },
        hindi: {
            title: "रक्षा कवच (Protection Shield)",
            subtitle: "एक वेब आधारित वास्तविक समय रिपोर्टिंग या अभिभावक अलर्ट महिला सुरक्षा और सुरक्षा प्रणाली आवेदन",
            adminTitle: "प्रशासन पोर्टल",
            adminText: "पूरे आवेदन और उपयोगकर्ता शिकायतों का प्रबंधन करें।",
            adminBtn: "प्रवेश प्रशासक",
            userTitle: "उपयोगकर्ता पोर्टल",
            userText: "शिकायतें दर्ज करें और अपनी प्रोफ़ाइल प्रबंधित करें।",
            userBtn: "प्रवेश उपयोगकर्ता",
            policeTitle: "पुलिस पोर्टल",
            policeText: "शिकायतों की समीक्षा करें और आवश्यक कार्य करें।",
            policeBtn: "प्रवेश पुलिस",
            aboutTitle: "आवेदन के बारे में",
            aboutText: "महिला सुरक्षा प्रणाली महिलाओं को सशक्त बनाने के लिए डिज़ाइन की गई है ताकि उन्हें शिकायतें दर्ज करने और उनकी सुरक्षा प्रबंधित करने के लिए एक सुरक्षित मंच मिल सके। यह उपयोगकर्ताओं को संबंधित अधिकारियों के साथ जोड़ता है, जो घटनाओं के लिए समय पर प्रतिक्रियाएँ सुनिश्चित करता है।",
            futureScopeTitle: "भविष्य का दायरा",
            futureScopeText: "भविष्य में, हम निम्नलिखित सुविधाओं को जोड़ने की योजना बना रहे हैं:",
            futureScopeText1:"आपातकालीन स्थितियों के लिए वास्तविक समय जीपीएस ट्रैकिंग",
            futureScopeText2:"त्वरित सहायता के लिए चैटबॉट समर्थन",
            futureScopeText3:"स्थानीय कानून प्रवर्तन डेटाबेस के साथ एकीकरण",
            futureScopeText4:"बेहतर पहुंच के लिए मोबाइल ऐप विकास"
        }
    };

    function toggleLanguage() {
        isHindi = !isHindi;
        const lang = isHindi ? "hindi" : "english";

        document.getElementById("title").innerText = content[lang].title;
        document.getElementById("subtitle").innerText = content[lang].subtitle;
        document.getElementById("adminTitle").innerText = content[lang].adminTitle;
        document.getElementById("adminText").innerText = content[lang].adminText;
        document.getElementById("adminBtn").innerText = content[lang].adminBtn;
        document.getElementById("userTitle").innerText = content[lang].userTitle;
        document.getElementById("userText").innerText = content[lang].userText;
        document.getElementById("userBtn").innerText = content[lang].userBtn;
        document.getElementById("policeTitle").innerText = content[lang].policeTitle;
        document.getElementById("policeText").innerText = content[lang].policeText;
        document.getElementById("policeBtn").innerText = content[lang].policeBtn;
        document.getElementById("aboutTitle").innerText = content[lang].aboutTitle;
        document.getElementById("aboutText").innerText = content[lang].aboutText;
        document.getElementById("futureScopeTitle").innerText = content[lang].futureScopeTitle;
        document.getElementById("futureScopeText").innerText = content[lang].futureScopeText;
        document.getElementById("futureScopeText1").innerText = content[lang].futureScopeText1;
        document.getElementById("futureScopeText2").innerText = content[lang].futureScopeText2;
        document.getElementById("futureScopeText3").innerText = content[lang].futureScopeText3;
        document.getElementById("futureScopeText4").innerText = content[lang].futureScopeText4;

        document.getElementById("languageButton").innerText = isHindi ? "EN" : "हिन्दी";
    }

    const cardsContainer = document.getElementById('slidingCards');
    let scrollAmount = 10; // Increase this value to make sliding faster
  
    function duplicateImages() {
      const images = Array.from(cardsContainer.children);
      images.forEach(image => {
        const clone = image.cloneNode(true);
        cardsContainer.appendChild(clone);
      });
    }
  
    function continuousScroll() {
      cardsContainer.scrollLeft += scrollAmount;
  
      if (cardsContainer.scrollLeft >= cardsContainer.scrollWidth / 2) {
        cardsContainer.scrollLeft = 0;
      }
    }
  
    function startAutoScroll() {
      setInterval(continuousScroll, 10); // Decrease interval for faster scrolling
    }
  
    document.querySelectorAll('.sliding-cards img').forEach(img => {
      img.addEventListener('mouseenter', () => scrollAmount = 0);
      img.addEventListener('mouseleave', () => scrollAmount = 10);
    });
  
    duplicateImages();
    startAutoScroll();

 
   // added more again
   const cardsContainerx = document.getElementById('slidingCard');
    const imagesx = document.querySelectorAll('.sliding-card img');
    const dotsContainer = document.getElementById('sliderDots');
    let currentIndexx = 0;

    // Create dots based on the number of images
    imagesx.forEach((_, index) => {
      const dot = document.createElement('div');
      dot.classList.add('dot');
      if (index === 0) dot.classList.add('active');
      dot.addEventListener('click', () => goToSlide(index));
      dotsContainer.appendChild(dot);
    });

    function goToSlide(index) {
      currentIndexx = index;
      updateSlider();
    }

    function updateSlider() {
      // Adjust transform for sliding effect
      cardsContainerx.style.transform = `translateX(-${currentIndexx * 1000}px)`;

      // Update active dot
      document.querySelectorAll('.dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === currentIndexx);
      });
    }

    function autoSlide() {
      currentIndexx = (currentIndexx + 1) % imagesx.length;
      updateSlider();
    }

    // Slide every 2.5 seconds
    setInterval(autoSlide, 2500);


</script>
</body>
</html>
