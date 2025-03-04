
document.addEventListener('DOMContentLoaded', function() {
  // Welcome toast
  showToast('Welcome to the dashboard', 'Your analytics data has been updated', 'success');
  
  // Initialize Revenue Chart
  const ctx = document.getElementById('revenueChart').getContext('2d');
  const chartData = {
    labels: ['14/08', '15/08', '16/08', '17/08', '18/08', '19/08', '20/08'],
    datasets: [
      {
        label: 'Revenue',
        data: [1.2, 2.3, 2.0, 4.8, 1.8, 1.5, 0],
        backgroundColor: 'rgba(59, 130, 246, 0.6)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderRadius: 8,
        borderWidth: 0,
        barPercentage: 0.6,
        categoryPercentage: 0.7,
      },
      {
        label: 'Expenses',
        data: [-2.1, -1.8, -2.4, -1.6, -2.2, -1.9, 0],
        backgroundColor: 'rgba(96, 165, 250, 0.6)',
        borderColor: 'rgba(96, 165, 250, 1)',
        borderRadius: 8,
        borderWidth: 0,
        barPercentage: 0.6,
        categoryPercentage: 0.7,
      }
    ]
  };
  
  new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: '#9ca3af'
          }
        },
        y: {
          min: -4,
          max: 5,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          },
          ticks: {
            color: '#9ca3af'
          }
        }
      },
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'white',
          titleColor: '#0f172a',
          bodyColor: '#64748b',
          borderColor: '#e2e8f0',
          borderWidth: 1,
          padding: 10,
          boxPadding: 6,
          cornerRadius: 8,
          displayColors: false
        }
      }
    }
  });
  
  // Initialize Progress Circle Animation
  initProgressCircle();
  
  // Initialize Search Bar Focus Event
  const searchInput = document.querySelector('.search-container input');
  const searchContainer = document.querySelector('.search-container');
  
  searchInput.addEventListener('focus', function() {
    searchContainer.style.width = '300px';
  });
  
  searchInput.addEventListener('blur', function() {
    searchContainer.style.width = '200px';
  });
  
  // Mobile Menu Toggle
  const menuButton = document.querySelector('.menu-button');
  const sidebar = document.querySelector('.sidebar');
  
  menuButton.addEventListener('click', function() {
    sidebar.classList.toggle('open');
  });
  
  // Initialize Bar Chart Animation
  initBarChartAnimation();
});

// Function to initialize the progress circle
function initProgressCircle() {
  const circle = document.getElementById('yearProgress');
  const percentage = 78; // Example percentage
  
  if (circle) {
    const radius = circle.r.baseVal.value;
    const circumference = radius * 2 * Math.PI;
    
    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = circumference;
    
    // Animate the circle
    setTimeout(() => {
      const offset = circumference - (percentage / 100) * circumference;
      circle.style.strokeDashoffset = offset;
    }, 300);
  }
}

// Function to animate the monthly chart bars
function initBarChartAnimation() {
  const bars = document.querySelectorAll('.chart-bar');
  
  bars.forEach((bar, index) => {
    // Get the height from the inline style
    const height = bar.style.height;
    
    // Set initial height to 0
    bar.style.height = '0px';
    
    // Animate to final height with delay based on index
    setTimeout(() => {
      bar.style.height = height;
    }, 400 + (index * 100));
  });
}

// Function to show a toast message
function showToast(title, message, type = 'default') {
  const toastContainer = document.getElementById('toast-container');
  
  // Create toast element
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  
  // Create content
  toast.innerHTML = `
    <div>
      <h4 style="font-weight: 600; margin-bottom: 4px;">${title}</h4>
      <p style="font-size: 0.875rem; color: #64748b;">${message}</p>
    </div>
  `;
  
  // Add to container
  toastContainer.appendChild(toast);
  
  // Remove after 5 seconds
  setTimeout(() => {
    toast.style.animation = 'fadeOut 0.3s forwards';
    setTimeout(() => {
      toast.remove();
    }, 300);
  }, 5000);
}
