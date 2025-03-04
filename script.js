
// Global variables
let currentQuestion = 1;
let timer;
let timerRunning = false;
let seconds = 0;

// DOM elements
const participantsSidebar = document.getElementById('participantsSidebar');
const showParticipantsBtn = document.getElementById('showParticipants');
const closeSidebarBtn = document.getElementById('closeSidebar');
const controlPanel = document.getElementById('controlPanel');
const toggleControlPanelBtn = document.getElementById('toggleControlPanel');
const closeControlPanelBtn = document.getElementById('closeControlPanel');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const revealBtn = document.getElementById('revealBtn');
const timerDisplay = document.getElementById('timer');
const currentQuestionDisplay = document.getElementById('currentQuestion');

// Initialize participants
function initParticipants() {
  const participantsGrid = document.querySelector('.participants-grid');
  
  // Create 60 participants
  for (let i = 1; i <= 60; i++) {
    const participant = document.createElement('div');
    participant.classList.add('participant');
    participant.textContent = i;
    
    participant.addEventListener('click', function() {
      this.classList.toggle('active');
    });
    
    participantsGrid.appendChild(participant);
  }
}

// Initialize question selector
function initQuestions() {
  const questionRadios = document.querySelectorAll('input[name="question"]');
  const prizeItems = document.querySelectorAll('.prize-item');
  
  // Add event listeners to radio buttons
  questionRadios.forEach(radio => {
    radio.addEventListener('change', function() {
      currentQuestion = parseInt(this.value);
      updateActiveQuestion(currentQuestion);
      currentQuestionDisplay.textContent = `${currentQuestion}/12`;
    });
  });
  
  // Initialize with question 1
  updateActiveQuestion(1);
  currentQuestionDisplay.textContent = `${currentQuestion}/12`;
}

// Update active question in prize list
function updateActiveQuestion(questionNumber) {
  const prizeItems = document.querySelectorAll('.prize-item');
  
  prizeItems.forEach(item => {
    item.classList.remove('active');
  });
  
  // Question numbers are in reverse order in the UI (12 to 1)
  const index = 12 - questionNumber;
  prizeItems[index].classList.add('active');
}

// Timer functions
function startTimer() {
  if (!timerRunning) {
    timerRunning = true;
    timer = setInterval(updateTimer, 1000);
    startBtn.disabled = true;
    pauseBtn.disabled = false;
  }
}

function pauseTimer() {
  if (timerRunning) {
    timerRunning = false;
    clearInterval(timer);
    startBtn.disabled = false;
    pauseBtn.disabled = true;
  }
}

function resetTimer() {
  pauseTimer();
  seconds = 0;
  updateTimerDisplay();
  startBtn.disabled = false;
  pauseBtn.disabled = false;
}

function updateTimer() {
  seconds++;
  updateTimerDisplay();
}

function updateTimerDisplay() {
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = seconds % 60;
  timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
}

// Event listeners
function setupEventListeners() {
  // Participants sidebar
  showParticipantsBtn.addEventListener('click', function() {
    participantsSidebar.classList.add('active');
    addOverlay();
  });
  
  closeSidebarBtn.addEventListener('click', function() {
    participantsSidebar.classList.remove('active');
    removeOverlay();
  });
  
  // Control panel
  toggleControlPanelBtn.addEventListener('click', function() {
    controlPanel.classList.toggle('active');
    if (controlPanel.classList.contains('active')) {
      addOverlay();
    } else {
      removeOverlay();
    }
  });
  
  closeControlPanelBtn.addEventListener('click', function() {
    controlPanel.classList.remove('active');
    removeOverlay();
  });
  
  // Game controls
  startBtn.addEventListener('click', startTimer);
  pauseBtn.addEventListener('click', pauseTimer);
  revealBtn.addEventListener('click', revealAnswer);
  
  // Answer options
  const answerOptions = document.querySelectorAll('.answer-option');
  answerOptions.forEach(option => {
    option.addEventListener('click', function() {
      answerOptions.forEach(opt => opt.classList.remove('selected'));
      this.classList.add('selected');
    });
  });
}

// Reveal the correct answer
function revealAnswer() {
  // This is just a placeholder - in a real app, you'd check against the actual correct answer
  const answerOptions = document.querySelectorAll('.answer-option');
  // For demo purposes, we'll always highlight option A as correct
  answerOptions[0].classList.add('correct');
}

// Overlay management
function addOverlay() {
  let overlay = document.querySelector('.overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);
  }
  overlay.classList.add('active');
  
  overlay.addEventListener('click', function() {
    participantsSidebar.classList.remove('active');
    controlPanel.classList.remove('active');
    removeOverlay();
  });
}

function removeOverlay() {
  const overlay = document.querySelector('.overlay');
  if (overlay) {
    overlay.classList.remove('active');
  }
}

// Initialize the app
function init() {
  initParticipants();
  initQuestions();
  setupEventListeners();
}

// Start the app when DOM is loaded
document.addEventListener('DOMContentLoaded', init);
