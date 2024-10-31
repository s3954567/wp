<?php
$title = "Pets Victoria";
include('includes/header.inc');
include('includes/nav.inc');
?>
<main>
    <div class="content">
        <!-- Left Column -->
        <div class="content-left">
            <h1 class="site-title">PETS VICTORIA</h1>
            <h2 class="welcome-text">WELCOME TO PET<br>ADOPTION</h2>
            
            <!-- Search Section -->
            <div class="search-container">
                <div class="search-inputs">
                    <input type="text" placeholder="I am looking for..." class="search-field">
                    <select class="pet-type-select">
                        <option value="">Select your pet type</option>
                        <option value="dog">Dogs</option>
                        <option value="cat">Cats</option>
                        <option value="other">Other Pets</option>
                    </select>
                    <button class="search-button">Search</button>
                </div>
            </div>

            <!-- Description Section -->
            <div class="description">
                <h3>Discover Pets Victoria</h3>
                <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, 
                   Australia, focused on providing a safe and loving environment for pets in need. 
                   With a compassionate approach, Pets Victoria works tirelessly to rescue, 
                   rehabilitate, and rehome dogs, cats, and other animals. Their mission is to 
                   connect these deserving pets with caring individuals and families, creating 
                   lifelong bonds.</p>
            </div>
        </div>

        <!-- Right Column - Image -->
        <div class="content-right">
            <img src="images/main.jpg" alt="Featured Pet" class="featured-image">
        </div>
    </div>
</main>
<?php
include('includes/footer.inc');
?>
