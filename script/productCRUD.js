// Chart.js for displaying product statistics
const ctx = document.getElementById('productChart').getContext('2d');
const productChart = new Chart(ctx, {
    type: 'bar', 
    data: {
        labels: ['Total Products', 'iPhones', 'Other Products'],
        datasets: [{
            label: 'Product Statistics',
            data: [150, 50, 100], // Sample data; replace with dynamic values
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
            borderColor: ['#FF6384', '#36A2EB', '#FFCE56'],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Form handling for CRUD operations
document.getElementById('productForm').addEventListener('submit', function (event) {
    event.preventDefault();
    alert("Product submitted for creation or update.");
    // Actual AJAX call to productcrud.php would go here
});

document.getElementById('deleteForm').addEventListener('submit', function (event) {
    event.preventDefault();
    alert("Product deletion request sent.");
});

// You can add similar event listeners for view, count, etc.
