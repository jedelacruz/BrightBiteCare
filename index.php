<?php


$pageTitle = "Home";
include "includes/header.php";


?>

  <style>
    .hero-section {
  background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.1), rgba(161, 222, 255, 0.5));
  padding: 4rem 0;
  overflow: hidden;
}

.hero-content {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

@media (min-width: 768px) {
  .hero-content {
    flex-direction: row;
    align-items: center;
  }
}

.hero-text {
  flex: 1;
}

.hero-text h1 {
  font-size: 2.5rem;
  line-height: 1.2;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: #333;
}

.hero-text h1 span.text-primary {
  color: #33C3F0;
}

.hero-text p {
  font-size: 1.125rem;
  color: #666;
  margin-bottom: 2rem;
  max-width: 500px;
}

.hero-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.hero-image {
  flex: 1;
  position: relative;
}

.hero-image img {
  width: 100%;
  height: auto;
  border-radius: 0.75rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Intro Section */
.intro-section {
  padding: 4rem 0;
}

.section-header {
  text-align: center;
  max-width: 700px;
  margin: 0 auto 3rem;
}

.section-header h2 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.section-header p {
  font-size: 1.125rem;
  color: #666;
}

.features-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 640px) {
  .features-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .features-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.feature-card {
  background: #fff;
  border-radius: 0.75rem;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.feature-icon {
  width: 4rem;
  height: 4rem;
  background-color: rgba(51, 195, 240, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
}

.feature-icon svg {
  width: 2rem;
  height: 2rem;
  color: #33C3F0;
}

.feature-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.75rem;
}

.feature-card p {
  font-size: 0.875rem;
  color: #666;
}

/* CTA Section */
.cta-section {
  background-color: rgba(51, 195, 240, 0.1);
  padding: 4rem 0;
  text-align: center;
}

.cta-section h2 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.cta-section p {
  font-size: 1.125rem;
  color: #666;
  max-width: 600px;
  margin: 0 auto 2rem;
}

.cta-buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1rem;
}

/* Quick Links Section */
.quick-links-section {
  padding: 4rem 0;
}

.quick-links-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .quick-links-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.quick-link-card {
  background: #fff;
  border-radius: 0.75rem;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  transition: transform 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.quick-link-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.quick-link-card h3 {
  font-size: 1.5rem;
  margin-bottom: 0.75rem;
}

.quick-link-card p {
  font-size: 1rem;
  color: #666;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.quick-link-card .btn {
  width: 100%;
  margin-top: auto;
}

  </style>

    <main class="main-content">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container">
        <div class="hero-content">
          <div class="hero-text">
            <h1>Healthy Smile <span class="text-primary">begins with care.</span></h1>
            <p>At Bright Bite Care, we're dedicated to providing exceptional dental care 
              for you and your family in a comfortable and friendly environment.</p>
            <div class="hero-buttons">
              <a href="services.php" class="btn btn-primary">Our Services</a>
              <a href="contactus.php" class="btn btn-outline">Contact Us</a>
            </div>
          </div>
          <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1670191247079-f9713ae06dcf?q=80&w=1325&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Smiling patient">
          </div>
        </div>
      </div>
    </section>

    <!-- Intro Section -->
    <section class="intro-section">
      <div class="container">
        <div class="section-header">
          <h2>Welcome to Bright Bite Care</h2>
          <p>Our modern dental clinic is equipped with state-of-the-art technology and staffed by experienced professionals 
            who are passionate about oral health and patient comfort.</p>
        </div>

        <!-- Features -->
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"></path>
                <path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"></path>
                <circle cx="20" cy="10" r="2"></circle>
              </svg>
            </div>
            <h3>Expert Care</h3>
            <p>Our team of skilled dentists provide comprehensive care for all your dental needs.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
            </div>
            <h3>Safety First</h3>
            <p>We maintain the highest standards of sterilization and infection control.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </div>
            <h3>Convenient Hours</h3>
            <p>We offer flexible scheduling options to accommodate your busy lifestyle.</p>
          </div>

          <div class="feature-card">
            <div class="feature-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                <line x1="15" y1="9" x2="15.01" y2="9"></line>
              </svg>
            </div>
            <h3>Comfort Focused</h3>
            <p>Enjoy a relaxing environment designed to make your visit stress-free.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <h2>Ready for a Brighter Smile?</h2>
        <p>Schedule your dental appointment today and take the first step towards optimal oral health.</p>
        <div class="cta-buttons">
          <a href="contactus.php" class="btn btn-primary">Book an Appointment</a>
          <a href="services.php" class="btn btn-outline">Explore Services</a>
        </div>
      </div>
    </section>

    <!-- Quick Links -->
    <section class="quick-links-section">
      <div class="container">
        <div class="quick-links-grid">
          <div class="quick-link-card">
            <h3>Our Services</h3>
            <p>Comprehensive dental care for all ages</p>
            <a href="services.php" class="btn btn-outline">View Services</a>
          </div>

          <div class="quick-link-card">
            <h3>About Us</h3>
            <p>Learn about our clinic and our experienced team</p>
            <a href="about.php" class="btn btn-outline">Meet Our Team</a>
          </div>

          <div class="quick-link-card">
            <h3>Contact Us</h3>
            <p>Get directions or reach out with questions</p>
            <a href="contactus.php" class="btn btn-outline">Get in Touch</a>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php include "includes/footer.php"; ?>