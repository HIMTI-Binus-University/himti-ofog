<?php
$req_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path_alias = ['about', 'faq', 'tellus', 'tellus-thanks', 'testimonies'];
for ($i = 0; $i < count($path_alias); $i++) if ($req_path == "/$path_alias[$i]") {
    header("Location: /$path_alias[$i].php");
    die();
}
include('components/testimonies-items.php');
include('components/journey-items.php');
?>

<!DOCTYPE html>
<html lang="en" style="overflow-y: hidden;">

<head>
    <?php
    $USE_BOOTSTRAP = true;
    require('components/head.php');
    ?>

    <link rel="stylesheet" href="assets/css/testimonies.css?v=2">
    <link rel="stylesheet" href="assets/css/ourjourney.css?v=2">
    <link rel="stylesheet" href="assets/css/gallery.css?v=2">
    
    <script>
        let activeProfile;

        function testimoniesImgClick(name) {
            if (name === activeProfile) {
            return;
            }
            const newImage = document.getElementById(name + "Photo");
            const newProfile = document.getElementById(name + "Profile");
            newImage.classList.add("profselector__img--active");
            newProfile.classList.remove("profdesc--hidden");
            
            const oldImage = document.getElementById(activeProfile + "Photo");
            const oldProfile = document.getElementById(activeProfile + "Profile");
            activeProfile = name;
            if(!oldImage || !oldProfile){
                return
            }
            oldImage.classList.remove("profselector__img--active");
            oldProfile.classList.add("profdesc--hidden");
        }

        // Function for animation in achievement section
        document.addEventListener("DOMContentLoaded", function() {
            const section = document.getElementById("our-journey-section");
            const pointer = document.getElementById("journeylist-pointer");
            const container = document.getElementById("journeylist-content");

            function updatePointerPosition() {
                const sectionRect = section.getBoundingClientRect();
                const pointerHeight = pointer.offsetHeight;
                const containerHeight = container.offsetHeight;

                // Only move pointer if section is visible in viewport
                if (sectionRect.bottom > 0 && sectionRect.top < window.innerHeight) {
                    const visibleTop = Math.max(sectionRect.top, 0);
                    const visibleBottom = Math.min(sectionRect.bottom, window.innerHeight);

                    // Tracks scrolling progress
                    const sectionScrollRange = sectionRect.height - window.innerHeight;
                    let scrollProgress = 0;
                    if (sectionScrollRange > 0) {
                        scrollProgress = (window.scrollY + visibleTop - section.offsetTop) / sectionScrollRange;
                        scrollProgress = Math.max(0, Math.min(1, scrollProgress));
                    }

                    // Borders
                    const minY = 0;
                    const maxY = containerHeight - pointerHeight - 100;

                    // Set pointer position within allowed range
                    const pointerY = minY + (maxY - minY) * scrollProgress;
                    pointer.style.position = "absolute";
                    pointer.style.top = pointerY + "px";

                    // Line made visible when pointer passes
                    const timelineDots = container.querySelectorAll('.journeylist-timeline');
                    timelineDots.forEach(dot => {
                        const dotTop = parseFloat(dot.style.top);
                        if (pointerY >= dotTop) {
                            dot.style.opacity = "1";
                        } else {
                            dot.style.opacity = "0";
                        }
                    });

                    // Event made visible when pointer passes
                    const events = container.querySelectorAll('.event');
                    events.forEach(event => {
                        const eventTop = event.offsetTop;
                        if (pointerY >= eventTop + 100) {
                            event.style.opacity = "1";
                        } else {
                            event.style.opacity = "0";
                        }
                    });
                }
            }

            window.addEventListener("scroll", updatePointerPosition);
            window.addEventListener("resize", updatePointerPosition);
            updatePointerPosition();
        });
    </script>
</head>

<body>
    <div id="Preloader">
        <object data="assets/animations/LogoAnimationHIMTI.svg" class="Line"></object>
        <object data="assets/animations/LogoFillHIMTI.svg" class="Line"></object>
    </div>
    <?php $NAVBAR_SET_IMMERSIVE = true;
    require_once('components/navbar.php'); ?>
    <div id="carouselExampleIndicators" class="carousel slide carouselmain" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            // if ($CarouselData != null || count($CarouselData) != 0) {
                // $Number = 0;
                // foreach ($CarouselData as $row) {
                    // if ($Number == 0) {
                        // echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                // aria-current="true" aria-label="Slide 1"></button>';
                        // $Number += 1;
                    // } else {
                        // echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $Number . '"
                // aria-label="Slide ' . $Number + 1 . '"></button>';
                        // $Number += 1;
                    // }
                // }
            // } else {
                // echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
            // }
            ?>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <object data="assets/animations/OFOGAnimation.svg" type=""
                    style="background-color: black; border-bottom-left-radius: 50px;border-bottom-right-radius: 50px;"></object>
            </div>
            <?php
            // in the db carousel is empty
            // $Number = 0;
            // if ($CarouselData != null || count($CarouselData) != 0) {
                // foreach ($CarouselData as $row) {
                    // if ($Number == 0) {
                        // echo '<div class="carousel-item active"><img class="d-block w-100 himti-header-img" src="' . $row['ImageLink'] . '" alt="' . $row['ImageName'] . '"></div>';
                        // $Number += 1;
                    // } else {
                        // echo '<div class="carousel-item"><img class="d-block w-100 himti-header-img" src="' . $row['ImageLink'] . '" alt="' . $row['ImageName'] . '"></div>';
                        // $Number += 1;
                    // }
                // }
            // } else {
                echo '';
            // }
            ?>

        </div>
        <?php
        // if ($CarouselData != null && count($CarouselData) > 1) {
            // echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            // data-bs-slide="prev">
            // <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            // <span class="visually-hidden">Previous</span>
        // </button>
        // <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            // data-bs-slide="next">
            // <span class="carousel-control-next-icon" aria-hidden="true"></span>
            // <span class="visually-hidden">Next</span>
        // </button>';
        // }
        ?>
    </div>

    <div class="upcomingevent container">
        <div class="title">
            <span>Upcoming Events</span>
        </div>
        <div class="upcomingeventdata">
            <a href="https://techno.himtibinus.or.id/" class="linkupcoming" target="_blank">
                <div class="upcomingeventrow">
                    <div style="height: 80%; display: flex; align-items: center;">
                        <!-- <img src="https://techno.himtibinus.or.id/asset/Logo%20TECHNO%202023.png" alt="" class="logo"> -->
                        <h2>Coming Soon!</h2>
                    </div>

                    <div class="upcomingeventitem shadow">
                        <!-- <p>Coming soon!</p> -->
                        <!-- <p data-countdown-enabled="true" data-countdown-timestamp="2023-09-10 13:00:00"></p> -->
                        <!-- <p>?? ?? 2024</p> -->
                    </div>
                </div>
            </a>
              <a href="https://hishot.himtibinus.or.id/" class="linkupcoming" target="_blank">
                <div class="upcomingeventrow">
                    <div class="image-container">
                        <img src="assets/img/events/HISHOT2026.svg" alt="" class="logo">
                    </div>

                    <div class="upcomingeventitem shadow">
                        <p>HISHOT 2026</p>
                        <p>12 June 2026</p>
                    </div>
                </div>
            </a>
               <a href="https://techfest.himtibinus.or.id/" class="linkupcoming" target="_blank">
                <div class="upcomingeventrow">
                    <div class="image-container">
                        <img src="assets/img/events/TECHFEST2026-2.svg" alt="" class="logo">
                    </div>

                    <div class="upcomingeventitem shadow">
                        <p>TECHFEST 2026</p>
                        <p>25 July 2026</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="testimonies-section">
        <div class="container">
            <!-- Header -->
            <div class="title mb-5">
                <span>Testimonies</span>
            </div>

            <div class="row g-4">
                <!-- Profile Selector -->
                <div class="col-lg-4">
                    <div class="profiles-container">
                        <h3 class="profiles-title">Alumni HIMTI</h3>
                        <div class="profiles-list">
                            <?php
                            $first = true;
                            if($testimonies != NULL && count($testimonies) > 0) {
                                foreach ($testimonies as $index => $testimony) {
                                    $activeClass = $first ? 'active' : '';
                                    echo '
                                    <div class="profile-card ' . $activeClass . '" 
                                        onclick="showTestimony(\'' . $testimony["id"] . '\', ' . $index . ')" 
                                        data-testimony-id="' . $testimony["id"] . '">
                                        <div class="profile-card-content">
                                            <img src="assets/img/testimonies-thumbnail/' . $testimony["id"] . 'Photo.webp" 
                                                alt="' . $testimony["name"] . '" 
                                                class="profile-avatar">
                                            <div class="profile-info">
                                                <h4 class="profile-name">' . $testimony["name"] . '</h4>
                                                <p class="profile-job">' . $testimony["job"] . '</p>
                                                <span class="profile-years">' . $testimony["active_years"] . '</span>
                                            </div>
                                        </div>
                                    </div>';
                                    $first = false;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Testimony Content -->
                <div class="col-lg-8">
                    <div class="testimony-container">
                        <?php
                        $first = true;
                        if($testimonies != NULL && count($testimonies) > 0) {
                            foreach ($testimonies as $index => $testimony) {
                                $activeClass = $first ? 'active' : '';
                                echo '
                                <div class="testimony-content ' . $activeClass . '" id="testimony-' . $testimony["id"] . '">
                                    <div class="testimony-header">
                                        <img src="assets/img/testimonies-thumbnail/' . $testimony["id"] . 'Photo.webp" 
                                                alt="' . $testimony["name"] . '" 
                                                class="testimony-avatar">
                                        <div class="testimony-info">
                                            <h2 class="testimony-name">' . $testimony["name"] . '</h2>
                                            <p class="testimony-job">' . $testimony["job"] . '</p>
                                            <span class="testimony-period">Kepengurusan HIMTI: ' . $testimony["active_years"] . '</span>
                                        </div>
                                    </div>

                                    <div class="experiences-section">
                                        <h3 class="experiences-title">Pengalaman di HIMTI</h3>
                                        <ul class="experiences-list">';
                                
                                foreach ($testimony['experiences'] as $experience) {
                                    echo '<li><strong>' . $experience['experience'] . '</strong> (' . $experience['year'] . ')</li>';
                                }
                                
                                echo '
                                        </ul>
                                    </div>

                                    <div class="testimony-text">
                                        <div class="quote-icon">"</div>
                                        <blockquote>' . nl2br($testimony["testimony"]) . '</blockquote>
                                    </div>
                                </div>';
                                $first = false;
                            }
                        }
                        ?>

                        <!-- Navigation -->
                        <div class="testimony-navigation">
                            <button class="nav-btn prev-btn" onclick="previousTestimony()">
                                <span>‹</span> Previous
                            </button>
                            
                            <div class="nav-dots">
                                <?php
                                if($testimonies != NULL && count($testimonies) > 0) {
                                    foreach ($testimonies as $index => $testimony) {
                                        $activeClass = $index === 0 ? 'active' : '';
                                        echo '<span class="nav-dot ' . $activeClass . '" onclick="showTestimonyByIndex(' . $index . ')"></span>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <button class="nav-btn next-btn" onclick="nextTestimony()">
                                Next <span>›</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="ourarticle">
        <div class="title">
            <span>Our Videos</span>
        </div>
        <div class="container">
            <div class="row" id="RSSarticle">

            </div>

        </div>
        <div class="articledata d-flex" style="overflow-x: auto;">

        </div>

        <div class="viewtestimoni mt-3"><a href="https://student-activity.binus.ac.id/himti"
                class="btn btn-light btn-lg text-dark">View All Videos</a></div>
    </div>


    <div class="OURJOURNEY" id="our-journey-section">
        <div class="title white">
            <span>Our Journey</span>
        </div>
        <div id="journeylist-container">
            <div id="journeylist-content">
                <?php 
                echo '<div id="journeylist-pointer"></div>';
                foreach($lines as $index => $line){
                    $top = $index * $offset;
                    echo '<div class="journeylist-timeline" style="top: ' . $top . 'px;"></div>';
                }
                foreach($journeys as $journey){
                    echo '<div class="event">';
                    if ($journey["imgurl"] != NULL) :
                        // echo '<img id="journeylist-img" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '"/>';
                        // echo '<div id="data-year-img"' . base64_encode($journey['year']);
                    endif;
                    echo '<div id="data-year">
                        '. ($journey["year"]) . '
                    </div>';
                    echo '<div id="journey1-modal">
                    '. ($journey["journey"]) .'
                    </div></div>';
                }
                
                ?>
            </div>

        </div>
    </div>

    <div class="pattern">
        <object data="assets/img/Transition.svg" alt="pattern-contact" class="objectdata"></object>
    </div>

    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="galleryModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="galleryModalImg" src="" class="img-fluid rounded" alt="">
            </div>
            </div>
        </div>
    </div>

    <div class="gallery min-vh-100">
        <div class="title" style="padding-top: 0;">
            <span>Gallery</span>
        </div>
        <div class="container-lg">
            <!-- Gallery Filter -->
            <div class="gallery-filter mb-4">
                <button class="filter-btn active" data-filter="all">General</button>
                <button class="filter-btn" data-filter="events">Events</button>
                <button class="filter-btn" data-filter="activities">Activities</button>
                <button class="filter-btn" data-filter="achievements">Achievements</button>
            </div>

            <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3" id="gallery-container">
                <?php
                    $gallery_items = [
                        ['img' => '1.jpg', 'category' => 'events', 'title' => 'SESVENT 2025'],
                        ['img' => '2.jpg', 'category' => 'activities', 'title' => 'SESVENT 2025'],
                        ['img' => '3.jpg', 'category' => 'achievements', 'title' => 'HILET 2025'],
                        ['img' => '4.jpg', 'category' => 'events', 'title' => 'HILET 2025'],
                        ['img' => '5.jpg', 'category' => 'activities', 'title' => 'HISHOT 2026 Seminar'],
                        ['img' => '6.jpg', 'category' => 'achievements', 'title' => 'HISHOT 2026 Seminar']
                    ];

                    foreach ($gallery_items as $item) {
                        echo '<div class="col gallery-item-wrapper" data-category="'.$item['category'].'">
                            <div class="gallery-item-container" 
                                data-bs-toggle="modal" 
                                data-bs-target="#galleryModal" 
                                data-img="assets/img/gallery/'.$item['img'].'" 
                                data-title="'.$item['title'].'">
                                
                                <img src="assets/img/gallery/'.$item['img'].'" class="gallery-item" alt="'.$item['title'].'">
                                
                                <div class="gallery-overlay" style="cursor: pointer;">
                                    <div class="gallery-overlay-content">
                                        <h5>'.$item['title'].'</h5>
                                        <i class="bi bi-zoom-in"></i>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="assets/js/gallerybutton.js?v=2"></script>
    
    <div class="FAQ mb-5">
        <div class="title" style="padding-top: 0;">
            <span>FREQUENTLY ASKED QUESTIONS</span>
        </div>
        <div class="container col-sm-12 my-5">
            <div class="accordion" id="accordionSection">
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne">Apa
                            kepanjangan HIMTI BINUS?</button>
                    </h2>
                    <div class="accordion-collapse collapse" id="collapseOne" data-bs-parent="#accordionSection">
                        <div class="accordion-body">
                            HIMTI BINUS merupakan kepanjangan dari Himpunan
                            Mahasiswa Teknik Informatika Universitas Bina Nusantara.
                        </div>
                    </div>

                </div>
                <div class="accordion-item  mb-3">
                    <h2 class="accordion-header">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo">Ada
                            berapa komisi dan divisi dalam HIMTI?</button>
                    </h2>
                    <div class="accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionSection">
                        <div class="accordion-body">
                            Di HIMTI BINUS sendiri terdapat empat komisi yang terdiri dari dua divisi di tiap
                            komisi.<br>
                            Komisi 1 yaitu <b>‘Education’</b> terdiri dari divisi Academic Event dan divisi Responsi.
                            <br>Komisi
                            2 yaitu <b>‘Relation Expansion’</b> terdiri dari divisi Publication and Marketing dan divisi
                            HIMTI
                            Care.<br>
                            Komisi 3 yaitu <b>‘Research and Development’</b> terdiri dari divisi Creative and
                            Design
                            dan divisi Web Development.<br>
                            Terakhir, Komisi 4 yaitu <b>‘Resource and Development’</b> terdiri dari Supervisor 
                            dan Human Resource Development.<br>
                            <br>

                            Untuk penjelasan lebih lengkapnya lagi, kamu dapat mengunjungi laman <a href="https://student-activity.binus.ac.id/himti/commission-and-division/">ini</a>

                        </div>
                    </div>

                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree">Mengapa
                            saya harus menjadi aktivis/pengurus HIMTI?</button>
                    </h2>
                    <div class="accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionSection">
                        <div class="accordion-body">
                            Dengan menjadi aktivis/pengurus HIMTI, kamu bisa mendapatkan banyak sekali manfaat
                            seperti
                            menambah relasi, mengembangkan soft skill serta hard skill, bagaimana mengelola waktu
                            dengan
                            lebih baik, dan tentunya masih banyak lagi manfaat lainnya yang akan kamu rasakan ketika
                            sudah menjadi aktivis/pengurus.
                            Yakin gak mau join? :)

                        </div>
                    </div>

                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour">Apakah
                            menjadi aktivis/pengurus HIMTI mengganggu aktivitas perkuliahan?</button>
                    </h2>
                    <div class="accordion-collapse collapse" id="collapseFour" data-bs-parent="#accordionSection">
                        <div class="accordion-body">
                            Tentu saja tidak. Dengan catatan, kamu dapat mengatur dan membagi waktu kamu dengan baik
                            mulai dari aktivitas perkuliahan, organisasi, dan beragam aktivitas lainnya. Time
                            management
                            yang baik itu penting, loh.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="viewtestimoni"><a href="/faq.php" class="btn btn-sm animated-button thar-three ">View All
                FAQs</a>
        </div>
    </div>

    <?php require_once('components/footer.php') ?>
    <script src="assets/js/script.js?v=2" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="assets/js/vanilla-tilt.min.js?v=2"></script>
    <script>
    VanillaTilt.init(document.querySelectorAll(".upcomingeventrow"), {
        max: 25,
        speed: 400
    });

    //It also supports NodeList
    VanillaTilt.init(document.querySelectorAll(".upcomingeventrow"));
    </script>
    <script src="assets/js/testimonies.js?v=2"></script>
    <script src="assets/js/RSShandle.js?v=<?= filemtime(__DIR__ . '/assets/js/RSShandle.js') ?>"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const galleryContainers = document.querySelectorAll(".gallery-item-container");
        const modalImg = document.getElementById("galleryModalImg");
        const modalTitle = document.getElementById("galleryModalLabel");

        // Modal logic
        galleryContainers.forEach(container => {
            container.addEventListener("click", () => {
            modalImg.src = container.dataset.img;
            modalTitle.textContent = container.dataset.title;
            });
        });

        // Filtering logic
        const filterBtns = document.querySelectorAll(".filter-btn");
        const galleryWrappers = document.querySelectorAll(".gallery-item-wrapper");

        filterBtns.forEach(btn => {
            btn.addEventListener("click", () => {
            filterBtns.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            const filter = btn.dataset.filter;
            galleryWrappers.forEach(wrapper => {
                wrapper.style.display = (filter === "all" || wrapper.dataset.category === filter)
                ? "block"
                : "none";
            });
            });
        });
        });
    </script>

</body>

</html>
