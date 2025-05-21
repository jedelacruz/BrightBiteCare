<?php

$pageTitle = "About Us";
include "includes/header.php";
?>

<style>
  .about-hero {
    background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.1), rgba(161, 222, 255, 0.5));
    padding: 4rem 0;
    text-align: center;
  }

  .about-hero h1 {
    font-size: 2.5rem;
    margin-bottom: .5rem;
  }

  .about-hero p {
    max-width: 800px;
    margin: 0 auto;
    font-size: 1.125rem;
    color: #555;
  }

  .vision-mission {
    padding: 4rem 0;
  }

  .card-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  @media (min-width: 768px) {
    .card-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .card h2 {
    font-size: 1.75rem;
    color: #33C3F0;
    margin-bottom: 1rem;
  }

  .highlight-text {
    font-size: 1.125rem;
    font-style: italic;
    margin-bottom: 1.5rem;
    color: #555;
  }

  .founders {
    padding: 4rem 0;
    background-color: #f9fafb;
  }

  .founders h2 {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 3rem;
  }

  .founders-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
  }

  @media (min-width: 768px) {
    .founders-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .founder-profile {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  @media (min-width: 640px) {
    .founder-profile {
      flex-direction: row;
    }
  }

  .founder-image {
    width: 100%;
    max-width: 300px;
  }

  .founder-image img {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .founder-info {
    flex: 1;
  }

  .founder-info h3 {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
  }

  .founder-role {
    font-size: 1.125rem;
    color: #33C3F0;
    margin-bottom: 1rem;
  }

  .journey {
    padding: 4rem 0;
  }

  .journey h2 {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 3rem;
  }

  .journey-container {
    max-width: 800px;
    margin: 0 auto;
    font-size: 1.125rem;
    line-height: 1.6;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    text-align: center;
  }

  .core-values {
    padding: 4rem 0;
    background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.05), rgba(161, 222, 255, 0.3));
  }

  .core-values h2 {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 3rem;
  }

  .values-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  @media (min-width: 640px) {
    .values-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1024px) {
    .values-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .value-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    text-align: center;
    height: 100%;
  }

  .value-card h3 {
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
  }
</style>

<!-- About Hero Section -->
<section class="about-hero">
  <h1>About Bright Bite Care</h1>
  <p>We are committed to providing exceptional dental care with a focus on patient comfort and satisfaction.</p>
</section>

<!-- Vision & Mission Section -->
<section class="vision-mission">
  <div class="card-grid">
    <div class="card">
      <h2>Our Vision</h2>
      <p class="highlight-text">"To be the leading dental care provider, setting new standards in oral healthcare."</p>
      <p>We envision a world where everyone has access to quality dental care and maintains optimal oral health throughout their lives.</p>
    </div>
    <div class="card">
      <h2>Our Mission</h2>
      <p class="highlight-text">"To provide comprehensive dental care with compassion and excellence."</p>
      <p>We are dedicated to delivering exceptional dental services while ensuring our patients feel comfortable and valued throughout their journey with us.</p>
    </div>
  </div>
</section>

<!-- Founders Section -->
<section class="founders">
  <h2>Meet Our Founders</h2>
  <div class="founders-grid">
    <div class="founder-profile">
      <div class="founder-image">
        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&q=80" alt="Dr. John Smith">
      </div>
      <div class="founder-info">
        <h3>Dr. John Smith</h3>
        <p class="founder-role">Chief Dental Officer</p>
        <p>With over 20 years of experience in dentistry, Dr. Smith leads our team with expertise and passion for dental care.</p>
      </div>
    </div>
    <div class="founder-profile">
      <div class="founder-image">
        <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?w=400&q=80" alt="Dr. Sarah Johnson">
      </div>
      <div class="founder-info">
        <h3>Dr. Sarah Johnson</h3>
        <p class="founder-role">Clinical Director</p>
        <p>Dr. Johnson brings innovation and compassion to our practice, ensuring the highest standards of patient care.</p>
      </div>
    </div>
  </div>
</section>

<!-- Journey Section -->
<section class="journey">
  <h2>Our Journey</h2>
  <div class="journey-container">
    <p>Founded in 2010, Bright Bite Care has grown from a small dental practice to a comprehensive dental care center. Our journey has been marked by continuous learning, innovation, and a steadfast commitment to patient care.</p>
    <p>Today, we serve thousands of patients annually, providing a wide range of dental services with state-of-the-art technology and a team of experienced professionals.</p>
  </div>
</section>

<!-- Core Values Section -->
<section class="core-values">
  <h2>Our Core Values</h2>
  <div class="values-grid">
    <div class="value-card">
      <h3>Excellence</h3>
      <p>We strive for excellence in everything we do, from patient care to professional development.</p>
    </div>
    <div class="value-card">
      <h3>Compassion</h3>
      <p>We treat every patient with kindness, understanding, and respect.</p>
    </div>
    <div class="value-card">
      <h3>Innovation</h3>
      <p>We embrace new technologies and techniques to provide the best possible care.</p>
    </div>
    <div class="value-card">
      <h3>Integrity</h3>
      <p>We maintain the highest standards of professional ethics and transparency.</p>
    </div>
  </div>
</section>

<?php include "includes/footer.php"; ?> 