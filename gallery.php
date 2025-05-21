<?php
// require_once "includes/session.php"; // REMOVED
require_once "includes/config.php"; // For DB connection if gallery items were dynamic

$pageTitle = "Gallery";
include "includes/header.php";
?>

<style>
.gallery-hero {
  background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.1), rgba(161, 222, 255, 0.5));
  padding: 4rem 0;
  text-align: center;
}

.gallery-hero h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.gallery-hero p {
  max-width: 800px;
  margin: 0 auto;
  font-size: 1.125rem;
  color: #555;
}

.gallery-section {
  padding: 4rem 0;
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .gallery-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.gallery-card {
  background: #fff;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.gallery-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.gallery-image-container {
  height: 16rem;
  overflow: hidden;
}

.gallery-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.gallery-card:hover .gallery-image {
  transform: scale(1.05);
}

.gallery-caption {
  padding: 1rem;
  text-align: center;
}

.gallery-caption p {
  font-size: 0.875rem;
  color: #666;
}
</style>

<main>
  <!-- Hero Section -->
  <section class="gallery-hero">
    <div class="container">
      <h1>Gallery</h1>
      <p>Take a visual tour of our clinic and facilities.</p>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery-section">
    <div class="container">
      <div class="gallery-grid">
        <div class="gallery-card">
          <div class="gallery-image-container">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Modern reception area" class="gallery-image">
          </div>
          <div class="gallery-caption">
            <p>Modern reception area</p>
          </div>
        </div>

        <div class="gallery-card">
          <div class="gallery-image-container">
            <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Dental examination room" class="gallery-image">
          </div>
          <div class="gallery-caption">
            <p>Dental examination room</p>
          </div>
        </div>

        <div class="gallery-card">
          <div class="gallery-image-container">
            <img src="https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Teeth whitening station" class="gallery-image">
          </div>
          <div class="gallery-caption">
            <p>Teeth whitening station</p>
          </div>
        </div>

        <div class="gallery-card">
          <div class="gallery-image-container">
            <img src="https://plus.unsplash.com/premium_photo-1682145291930-43b73e27446e?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Dental treatment room" class="gallery-image">
          </div>
          <div class="gallery-caption">
            <p>Dental treatment room</p>
          </div>
        </div>  

        <div class="gallery-card">
          <div class="gallery-image-container">
            <img src="https://images.unsplash.com/photo-1629909615184-74f495363b67?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Dental hygiene station" class="gallery-image">
          </div>
          <div class="gallery-caption">
            <p>Dental hygiene station</p>
          </div>
        </div>

        <div class="gallery-card">
          <div class="gallery-image-container">
            <img src="https://images.unsplash.com/photo-1606265752439-1f18756aa5fc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Patient consultation room" class="gallery-image">
          </div>
          <div class="gallery-caption">
            <p>Patient consultation room</p>
          </div>
        </div>

        

        
      </div>
    </div>
  </section>
</main>

<?php include "includes/footer.php"; ?> 