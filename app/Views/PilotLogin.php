<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>CKC Information Technology</title>
  <link rel="icon" href="/img/logo.png" type="image/png" />
  <meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    /* ========================= GLOBAL STYLES ========================= */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #0d2a4e;
      color: #e0f0ff;
      overflow-x: hidden;
      position: relative;
      min-height: 100vh;
      z-index: 0;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('/img/bg.jpg') no-repeat center center / cover;
      filter: blur(10px) brightness(0.4);
      z-index: -1;
    }

    /* ========================= NAVBAR ========================= */
    .navbar-blur {
      background: rgba(0, 44, 89, 0.85);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(74, 200, 224, 0.15);
    }

    .navbar-brand {
      color: #4ac8e0 !important;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      white-space: nowrap;
    }

    .navbar-brand img {
      height: 40px;
      width: 40px;
      object-fit: contain;
    }

    .brand-text {
      font-size: 1rem;
      color: #4ac8e0;
    }

    .navbar-blur .nav-link {
      color: #cde9fb;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar-blur .nav-link:hover,
    .navbar-blur .nav-link.active {
      color: #4ac8e0;
    }

    @media (max-width: 576px) {
      .navbar-brand img {
        height: 32px;
        width: 32px;
      }

      .brand-text {
        font-size: 0.9rem;
        display: inline-block;
        white-space: normal;
        line-height: 1.1;
      }
    }

    /* ========================= HERO SECTION ========================= */
    #home {
      padding: 160px 0 100px;
      color: #fff;
    }

    .hero-text {
      max-width: 600px;
    }

    .hero-text h1 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #4ac8e0;
    }

    .hero-text p {
      font-size: 1.1rem;
      line-height: 1.7;
      color: #d8eaf8;
    }

    .btn-hero {
      background-color: #4ac8e0;
      border: none;
      color: #0d2a4e;
      font-weight: 600;
      padding: 10px 28px;
      border-radius: 50px;
      transition: 0.3s;
    }

    .btn-hero:hover {
      background-color: #3ab4cc;
      color: #fff;
    }

    /* ========================= SECTION TITLE ========================= */
    h2.section-title {
      color: #4ac8e0;
      font-weight: 700;
      text-align: center;
      margin-bottom: 40px;
      text-transform: uppercase;
    }

    /* ========================= ABOUT ========================= */
    .about-box {
      background: rgba(74, 200, 224, 0.1);
      border: 1px solid rgba(74, 200, 224, 0.3);
      border-radius: 20px;
      padding: 30px;
      line-height: 1.8;
      color: #e0f0ff;
    }

    .about-box h5 {
      color: #4ac8e0;
      margin-top: 20px;
      font-weight: 600;
    }

    /* ========================= EVENT CARDS ========================= */
    .card-glass {
      background: rgba(74, 200, 224, 0.15);
      border: 1px solid rgba(74, 200, 224, 0.3);
      backdrop-filter: blur(14px);
      border-radius: 20px;
      color: #e0f0ff;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
      transition: transform 0.2s ease-in-out;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      text-align: left;
      padding: 20px;
    }

    .card-glass:hover {
      transform: translateY(-4px);
    }

    .card-glass img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 14px;
      margin-bottom: 15px;
    }

    .card-glass h5 {
      font-weight: 600;
      color: #4ac8e0;
    }

    .btn-login {
      background-color: #4ac8e0;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 30px;
      padding: 6px 18px;
    }

    .btn-login:hover {
      background-color: #3ab4cc;
      color: #fff;
    }

    /* ========================= FACULTY & OFFICERS ========================= */
    .teacher-card {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(74, 200, 224, 0.3);
      backdrop-filter: blur(18px);
      border-radius: 20px;
      padding: 30px;
      color: #fff;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
      text-align: center;
      transition: transform 0.3s;
      height: 100%;
    }

    .teacher-card:hover {
      transform: translateY(-6px);
    }

    .teacher-card img {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      border: 3px solid #4ac8e0;
      margin-bottom: 15px;
      object-fit: cover;
    }

    /* ========================= MODAL ========================= */
    .modal-content {
      background: rgba(0, 44, 89, 0.95);
      border: 1px solid rgba(74, 200, 224, 0.3);
      backdrop-filter: blur(14px);
      color: #e0f0ff;
      border-radius: 16px;
    }

    .modal-header {
      border-bottom: 1px solid rgba(74, 200, 224, 0.2);
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(74, 200, 224, 0.3);
      color: #fff;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.15);
      border-color: #4ac8e0;
      box-shadow: 0 0 0 0.25rem rgba(74, 200, 224, 0.25);
    }

    footer {
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.7);
      background: rgba(0, 44, 89, 0.7);
      margin-top: 50px;
    }
  </style>
</head>

<body> <!-- ========================= NAVBAR ========================= -->
  <nav class="navbar navbar-expand-lg navbar-blur fixed-top">
    <div class="container"> <a class="navbar-brand" href="#"> <img src="/img/logo.png" alt="CKC IT Logo"> <span class="brand-text">CKC Information Technology</span> </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> <span class="navbar-toggler-icon text-light"><i class="bi bi-list"></i></span> </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
          <li class="nav-item"><a class="nav-link" href="#faculty">Faculty</a></li>
          <li class="nav-item"><a class="nav-link" href="#officers">Officers</a></li>
          <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
        </ul>
      </div>
    </div>
  </nav> <!-- ========================= HERO SECTION ========================= -->
  <section id="home" class="d-flex align-items-center">
    <div class="container">
      <div class="hero-text">
        <h1>Empowering Future Innovators in Information Technology</h1>
        <p>Ready to elevate your skills and career in IT? Join CKC Information Technology — where innovation meets purpose and excellence is powered by values.</p> <a href="#about" class="btn btn-hero mt-3">Get Started</a>
      </div>
    </div>
  </section> <!-- ========================= ABOUT SECTION ========================= -->
  <section id="about" class="container py-5">
    <h2 class="section-title">About the IT Program</h2>
    <div class="about-box">
      <p><strong>About the Program:</strong> The IT program includes the study of the utilization of both hardware and software technologies involving planning, installing, customizing, operating, managing and administering, and maintaining information technology infrastructure that provides computing solutions to address the needs of an organization.</p>
      <h5>Program Goal</h5>
      <p>Information Technology Program aims to become skilled in Information Technology with their knowledge on the development, implementation, and management of information systems in a wide variety of contexts.</p>
      <h5>Program Objectives</h5>
      <ul>
        <li>Demonstrate competence in implementing IT solutions responsive to community needs, imbued with Ignacian Marian values.</li>
        <li>Apply responsibly and effectively the concepts of software development and network management.</li>
        <li>Exercise critical-thinking, communication, and problem-solving skills.</li>
      </ul>
      <h5>Career Opportunities</h5>
      <ul>
        <li>Web and Applications Developer</li>
        <li>Systems Administrator</li>
        <li>Network Engineer</li>
        <li>IT Instructor</li>
        <li>Software Engineer</li>
      </ul>
    </div>
  </section> <!-- ========================= EVENTS SECTION ========================= -->
  <section id="events" class="container py-5">
    <h2 class="section-title">IT Program Events</h2>
    <div class="row g-4">
      <div class="col-md-4 col-sm-6">
        <div class="card-glass"> <img src="/img/event1.jpg" alt="Event 1">
          <div>
            <h5>BSIT Team Building 2025</h5>
            <p>Uniting IT students through collaboration and leadership.</p>
          </div> <a href="https://www.facebook.com/share/p/19uKFk9z6W/" target="_blank" class="btn btn-login mt-2">View on Facebook</a>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="card-glass"> <img src="/img/event2.jpg" alt="Event 2">
          <div>
            <h5>Tech Seminar 2025</h5>
            <p>Exploring the latest in innovation, coding, and AI trends.</p>
          </div> <a href="https://www.facebook.com/share/p/14RmfuXJwuD/" target="_blank" class="btn btn-login mt-2">View on Facebook</a>
        </div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="card-glass"> <img src="/img/event3.jpg" alt="Event 3">
          <div>
            <h5>Hackathon Challenge</h5>
            <p>Showcasing creativity and problem-solving through technology.</p>
          </div> <a href="https://www.facebook.com/share/p/17bksLYw2C/" target="_blank" class="btn btn-login mt-2">View on Facebook</a>
        </div>
      </div>
    </div>
  </section> <!-- ========================= FACULTY ========================= -->
  <section id="faculty" class="container py-5">
    <h2 class="section-title">IT Faculty</h2>
    <div class="row g-4">
      <div class="col-md-3 col-sm-6">
        <div class="teacher-card"> <img src="/img/faculty1.jpg" alt="Faculty 1">
          <h5>Dr. Carlito T. Cabasag, Ph.D. TM.</h5>
          <p>IT Program Coordinator</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="teacher-card"> <img src="/img/faculty/f1.jpg" alt="Faculty 2">
          <h5>Adrian Pol Peligrino</h5>
          <p>IT Instructor</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="teacher-card"> <img src="/img/faculty3.jpg" alt="Faculty 3">
          <h5>Ms. Maria Lyn Saludes</h5>
          <p>IT Instructor</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="teacher-card"> <img src="/img/faculty4.jpg" alt="Faculty 4">
          <h5>Mr. Raymond P. Guillermo</h5>
          <p>Hardware Head</p>
        </div>
      </div>
    </div>
  </section> <!-- ========================= OFFICERS ========================= -->
  <section id="officers" class="container py-5">
    <h2 class="section-title">IT Program Officers</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-3 col-sm-6">
        <div class="teacher-card"> <img src="/img/officers/gov.jpg" alt="Officer 1">
          <h5>Calvin Joshua Kiunasala</h5>
          <p>Governor</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="teacher-card"> <img src="/img/officers/vgov.jpg" alt="Officer 2">
          <h5>John Rey Escabarte</h5>
          <p>Vice Governor</p>
        </div>
      </div>
    </div>
  </section> <!-- ========================= LOGIN MODAL ========================= -->
  <!-- ========================= LOGIN MODAL ========================= -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header">
          <h5 class="modal-title">Login</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/login">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="facultyId" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-login">Login</button>
            </div>
          </form>

          <!-- 🔗 Register Link -->
          <div class="text-center mt-2">
            <small>Don't have an account?
              <a href="#" class="text-info" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">
                Register Here
              </a>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================= REGISTER MODAL ========================= -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header">
          <h5 class="modal-title">Student Registration</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/register">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" name="fullName" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
              <label class="form-label">School ID</label>
              <input type="text" class="form-control" name="schoolId" placeholder="Enter school ID" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Year Level</label>
              <select class="form-select" name="yearLevel" required>
                <option value="" disabled selected>Select year level</option>
                <option>1st Year</option>
                <option>2nd Year</option>
                <option>3rd Year</option>
                <option>4th Year</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <div class="input-group">
                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                <button class="btn btn-outline-info" type="button" id="sendCodeBtn">Send Code</button>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Enter OTP Code</label>
              <input type="text" class="form-control" name="otpCode" placeholder="Enter 6-digit code" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter password" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-login">Register</button>
            </div>

            <div class="text-center mt-3">
              <small>Already have an account?
                <a href="#" class="text-info" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                  Login Here
                </a>
              </small>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================= OPTIONAL JS FOR SEND CODE ========================= -->
  <script>
    document.getElementById("sendCodeBtn").addEventListener("click", function() {
      alert("An OTP code has been sent to your email!");
    });
  </script>

  <footer> © 2025 Christ the King College Gingoog – Information Technology Department </footer> <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>