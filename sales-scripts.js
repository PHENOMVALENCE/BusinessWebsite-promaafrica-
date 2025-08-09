// Sample property data - In real implementation, this would come from database
/*const sampleProperties = [
   {
        id: 1,
        title: "Modern 3BR House in Mikocheni",
        location: "Dar es Salaam",
        property_type: "house",
        price: 450000000,
        bedrooms: 3,
        bathrooms: 2,
        area: 250,
        featured: true,
        images: ["https://via.placeholder.com/400x250/f6ae01/000000?text=House+1"],
        description: "Beautiful modern house with spacious rooms and modern amenities."
    },
    {
        id: 2,
        title: "Luxury Apartment in Stone Town",
        location: "Zanzibar",
        property_type: "apartment",
        price: 280000000,
        bedrooms: 2,
        bathrooms: 2,
        area: 120,
        featured: false,
        images: ["https://via.placeholder.com/400x250/f6ae01/000000?text=Apartment+1"],
        description: "Stunning apartment in the heart of Stone Town with ocean views."
    },
    {
        id: 3,
        title: "Commercial Plot in Arusha",
        location: "Arusha",
        property_type: "land",
        price: 150000000,
        bedrooms: 0,
        bathrooms: 0,
        area: 1000,
        featured: true,
        images: ["https://via.placeholder.com/400x250/f6ae01/000000?text=Land+1"],
        description: "Prime commercial land in the business district of Arusha."
    },
    {
        id: 4,
        title: "Beachfront Villa in Kendwa",
        location: "Zanzibar",
        property_type: "house",
        price: 850000000,
        bedrooms: 4,
        bathrooms: 3,
        area: 350,
        featured: true,
        images: ["https://via.placeholder.com/400x250/f6ae01/000000?text=Villa+1"],
        description: "Exclusive beachfront villa with private beach access."
    },
    {
        id: 5,
        title: "Office Space in CBD",
        location: "Dar es Salaam",
        property_type: "commercial",
        price: 320000000,
        bedrooms: 0,
        bathrooms: 2,
        area: 180,
        featured: false,
        images: ["https://via.placeholder.com/400x250/f6ae01/000000?text=Office+1"],
        description: "Modern office space in the central business district."
    },
    {
        id: 6,
        title: "Family Home in Mwanza",
        location: "Mwanza",
        property_type: "house",
        price: 380000000,
        bedrooms: 4,
        bathrooms: 3,
        area: 280,
        featured: false,
        images: ["https://via.placeholder.com/400x250/f6ae01/000000?text=House+2"],
        description: "Spacious family home with garden and parking space."
    } -->
]; */

let currentProperties = [...sampleProperties];
let currentPage = 1;
const propertiesPerPage = 6;

document.addEventListener('DOMContentLoaded', () => {
    initializeApp();
});

function initializeApp() {
    setupEventListeners();
    renderProperties();
    setupMobileDetection();
}

function setupEventListeners() {
    // Mobile menu
    const menuToggle = document.getElementById('mobileMenuToggle');
    const navLinks = document.getElementById('navLinks');
    const closeBtn = document.getElementById('closeBtn');

    if (menuToggle && navLinks && closeBtn) {
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            menuToggle.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
        });

        closeBtn.addEventListener('click', () => {
            navLinks.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        });

        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !navLinks.contains(e.target) && navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                menuToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // Search form
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleSearch();
        });
    }

    // View toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const propertiesGrid = document.getElementById('propertiesGrid');

    if (gridView && listView && propertiesGrid) {
        gridView.addEventListener('click', () => {
            propertiesGrid.classList.remove('list');
            gridView.classList.add('active');
            listView.classList.remove('active');
        });

        listView.addEventListener('click', () => {
            propertiesGrid.classList.add('list');
            listView.classList.add('active');
            gridView.classList.remove('active');
        });
    }

    // Modal events
    const modal = document.getElementById('inquiryModal');
    const modalOverlay = document.querySelector('.modal-overlay');
    
    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeInquiryModal);
    }

    // Inquiry form
    const inquiryForm = document.getElementById('inquiryForm');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', handleInquirySubmit);
    }

    // Escape key to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeInquiryModal();
        }
    });
}

function setupMobileDetection() {
    const isMobile = window.innerWidth < 768;
    const quickContactBar = document.getElementById('quickContactBar');
    
    if (quickContactBar) {
        quickContactBar.style.display = isMobile ? 'flex' : 'none';
    }
}

function handleSearch() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const propertyType = document.getElementById('propertyType').value;
    const locationFilter = document.getElementById('locationFilter').value;
    const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
    const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;
    const sortBy = document.getElementById('sortBy').value;

    // Filter properties
    currentProperties = sampleProperties.filter(property => {
        const matchesSearch = !searchInput || 
            property.title.toLowerCase().includes(searchInput) ||
            property.description.toLowerCase().includes(searchInput) ||
            property.location.toLowerCase().includes(searchInput);
        
        const matchesType = !propertyType || property.property_type === propertyType;
        const matchesLocation = !locationFilter || property.location === locationFilter;
        const matchesPrice = property.price >= minPrice && property.price <= maxPrice;

        return matchesSearch && matchesType && matchesLocation && matchesPrice;
    });

    // Sort properties
    switch (sortBy) {
        case 'newest':
            currentProperties.sort((a, b) => b.id - a.id);
            break;
        case 'price_low':
            currentProperties.sort((a, b) => a.price - b.price);
            break;
        case 'price_high':
            currentProperties.sort((a, b) => b.price - a.price);
            break;
        case 'featured':
        default:
            currentProperties.sort((a, b) => {
                if (a.featured && !b.featured) return -1;
                if (!a.featured && b.featured) return 1;
                return b.id - a.id;
            });
            break;
    }

    currentPage = 1;
    renderProperties();
}

function renderProperties() {
    const propertiesGrid = document.getElementById('propertiesGrid');
    const propertyCount = document.getElementById('propertyCount');
    
    if (!propertiesGrid) return;

    // Update property count
    if (propertyCount) {
        propertyCount.textContent = currentProperties.length;
    }

    // Calculate pagination
    const startIndex = (currentPage - 1) * propertiesPerPage;
    const endIndex = startIndex + propertiesPerPage;
    const paginatedProperties = currentProperties.slice(startIndex, endIndex);

    if (paginatedProperties.length === 0) {
        propertiesGrid.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-home"></i>
                <h3>No Properties Found</h3>
                <p>Try adjusting your search criteria to find more properties.</p>
                <button onclick="clearFilters()" class="btn-primary">Clear Filters</button>
            </div>
        `;
        renderPagination();
        return;
    }

    propertiesGrid.innerHTML = paginatedProperties.map(property => `
        <div class="property-card" data-property-id="${property.id}">
            <div class="property-image">
                <img src="${property.images[0]}" alt="${property.title}" loading="lazy">
                ${property.featured ? '<div class="featured-badge"><i class="fas fa-star"></i> Featured</div>' : ''}
                <div class="property-price">${formatPrice(property.price)}</div>
                <button class="favorite-btn" onclick="toggleFavorite(${property.id})" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                </button>
            </div>
            <div class="property-content">
                <h3 class="property-title">${property.title}</h3>
                <div class="property-location">
                    <i class="fas fa-map-marker-alt"></i>
                    ${property.location}
                </div>
                ${renderPropertyFeatures(property)}
                <div class="property-actions">
                    <button onclick="viewProperty(${property.id})" class="btn-view">
                        View Details
                    </button>
                    <a href="https://wa.me/255756069451?text=Hi%2C%20I%27m%20interested%20in%20${encodeURIComponent(property.title)}" 
                       class="btn-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    `).join('');

    renderPagination();
    
    // Initialize favorites from localStorage
    initializeFavorites();
}

function renderPropertyFeatures(property) {
    const features = [];
    
    if (property.bedrooms > 0) {
        features.push(`<span><i class="fas fa-bed"></i> ${property.bedrooms}</span>`);
    }
    
    if (property.bathrooms > 0) {
        features.push(`<span><i class="fas fa-bath"></i> ${property.bathrooms}</span>`);
    }
    
    if (property.area > 0) {
        features.push(`<span><i class="fas fa-ruler-combined"></i> ${property.area.toLocaleString()} m²</span>`);
    }

    return features.length > 0 ? `<div class="property-features">${features.join('')}</div>` : '';
}

function renderPagination() {
    const pagination = document.getElementById('pagination');
    if (!pagination) return;

    const totalPages = Math.ceil(currentProperties.length / propertiesPerPage);
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }

    let paginationHTML = '';

    // Previous button
    if (currentPage > 1) {
        paginationHTML += `
            <button class="pagination-btn" onclick="changePage(${currentPage - 1})">
                <i class="fas fa-chevron-left"></i> Previous
            </button>
        `;
    }

    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);

    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}" 
                    onclick="changePage(${i})">${i}</button>
        `;
    }

    // Next button
    if (currentPage < totalPages) {
        paginationHTML += `
            <button class="pagination-btn" onclick="changePage(${currentPage + 1})">
                Next <i class="fas fa-chevron-right"></i>
            </button>
        `;
    }

    pagination.innerHTML = paginationHTML;
}

function changePage(page) {
    currentPage = page;
    renderProperties();
    
    // Scroll to top of properties section
    const propertiesSection = document.querySelector('.properties-section');
    if (propertiesSection) {
        propertiesSection.scrollIntoView({ behavior: 'smooth' });
    }
}

function formatPrice(price) {
    const isMobile = window.innerWidth < 768;
    
    if (isMobile) {
        if (price >= 1000000000) {
            return 'TSh ' + (price / 1000000000).toFixed(1) + 'B';
        } else if (price >= 1000000) {
            return 'TSh ' + (price / 1000000).toFixed(1) + 'M';
        } else if (price >= 1000) {
            return 'TSh ' + (price / 1000).toFixed(0) + 'K';
        }
        return 'TSh ' + price.toLocaleString();
    }
    
    return 'TSh ' + price.toLocaleString();
}

function viewProperty(propertyId) {
    const property = sampleProperties.find(p => p.id === propertyId);
    if (property) {
        // In a real application, this would navigate to a detailed property page
        alert(`Viewing property: ${property.title}\n\nPrice: ${formatPrice(property.price)}\nLocation: ${property.location}\n\nDescription: ${property.description}`);
    }
}

function toggleFavorite(propertyId) {
    const favoriteBtn = document.querySelector(`.property-card[data-property-id="${propertyId}"] .favorite-btn`);
    if (favoriteBtn) {
        favoriteBtn.classList.toggle('active');
        const isActive = favoriteBtn.classList.contains('active');
        
        // Update icon
        const icon = favoriteBtn.querySelector('i');
        icon.className = isActive ? 'fas fa-heart' : 'far fa-heart';
        
        // Store in localStorage
        localStorage.setItem(`favorite_${propertyId}`, isActive ? 'true' : 'false');
    }
}

function initializeFavorites() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        const propertyCard = btn.closest('.property-card');
        const propertyId = propertyCard.dataset.propertyId;
        
        if (localStorage.getItem(`favorite_${propertyId}`) === 'true') {
            btn.classList.add('active');
            const icon = btn.querySelector('i');
            icon.className = 'fas fa-heart';
        }
    });
}

function openInquiryModal(propertyId = '', propertyTitle = '') {
    const modal = document.getElementById('inquiryModal');
    const propertyIdInput = document.getElementById('propertyId');
    const messageInput = document.getElementById('inquiryMessage');
    
    if (modal && propertyIdInput && messageInput) {
        propertyIdInput.value = propertyId;
        messageInput.value = propertyTitle ? 
            `Hi, I'm interested in the property: ${propertyTitle}. Could you provide more details?` : 
            'Hi, I\'m interested in your properties. Could you provide more information?';
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeInquiryModal() {
    const modal = document.getElementById('inquiryModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function handleInquirySubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const inquiryData = {
        property_id: formData.get('property_id'),
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        message: formData.get('message')
    };
    
    // In a real application, this would send data to the server
    console.log('Inquiry submitted:', inquiryData);
    
    // Show success message
    alert('Thank you for your inquiry! We will get back to you soon.');
    
    // Close modal and reset form
    closeInquiryModal();
    e.target.reset();
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('propertyType').value = '';
    document.getElementById('locationFilter').value = '';
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '';
    document.getElementById('sortBy').value = 'featured';
    
    currentProperties = [...sampleProperties];
    currentPage = 1;
    renderProperties();
}

// Responsive handling
window.addEventListener('resize', () => {
    setupMobileDetection();
    renderProperties(); // Re-render to update price formatting
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId !== '#') {
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
});