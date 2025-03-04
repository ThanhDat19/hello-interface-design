
document.addEventListener('DOMContentLoaded', function() {
  // Elements
  const participantsSidebar = document.getElementById('participantsSidebar');
  const showParticipantsBtn = document.getElementById('showParticipants');
  const closeSidebarBtn = document.getElementById('closeSidebar');
  const controlPanel = document.getElementById('controlPanel');
  const toggleControlPanelBtn = document.getElementById('toggleControlPanel');
  const closeControlPanelBtn = document.getElementById('closeControlPanel');
  const timerElement = document.getElementById('timer');
  const startBtn = document.getElementById('startBtn');
  const pauseBtn = document.getElementById('pauseBtn');
  const revealBtn = document.getElementById('revealBtn');
  const answerOptions = document.querySelectorAll('.answer-option');
  const questionText = document.getElementById('questionText');
  const currentMoney = document.getElementById('currentMoney');
  const questionItems = document.querySelectorAll('.question-item input');
  
  // Variables
  let timerInterval;
  let seconds = 0;
  let minutes = 0;
  let isTimerRunning = false;
  let currentQuestion = 1;
  let answerRevealed = false;
  let correctAnswer = 'A'; // Default correct answer, would be set based on actual question

  // Generate participants for the grid
  const participantsGrid = document.querySelector('.participants-grid');
  for (let i = 1; i <= 60; i++) {
    const participant = document.createElement('div');
    participant.classList.add('participant');
    participant.textContent = i;
    participant.addEventListener('click', function() {
      this.classList.toggle('active');
    });
    participantsGrid.appendChild(participant);
  }

  // Show/hide participants sidebar
  showParticipantsBtn.addEventListener('click', function() {
    participantsSidebar.style.left = '0';
    document.body.classList.add('sidebar-open');
    
    // Create overlay if it doesn't exist
    if (!document.querySelector('.overlay')) {
      const overlay = document.createElement('div');
      overlay.classList.add('overlay');
      document.body.appendChild(overlay);
      
      overlay.addEventListener('click', function() {
        participantsSidebar.style.left = '-300px';
        document.body.classList.remove('sidebar-open');
        this.classList.remove('active');
      });
    }
    
    document.querySelector('.overlay').classList.add('active');
  });

  closeSidebarBtn.addEventListener('click', function() {
    participantsSidebar.style.left = '-300px';
    document.body.classList.remove('sidebar-open');
    document.querySelector('.overlay').classList.remove('active');
  });

  // Show/hide control panel
  toggleControlPanelBtn.addEventListener('click', function() {
    controlPanel.classList.toggle('active');
    if (controlPanel.classList.contains('active')) {
      controlPanel.style.right = '0';
    } else {
      controlPanel.style.right = '-300px';
    }
  });

  closeControlPanelBtn.addEventListener('click', function() {
    controlPanel.classList.remove('active');
    controlPanel.style.right = '-300px';
  });

  // Timer functions
  function startTimer() {
    if (!isTimerRunning) {
      isTimerRunning = true;
      timerInterval = setInterval(updateTimer, 1000);
      startBtn.classList.add('pulse-animation');
    }
  }

  function pauseTimer() {
    if (isTimerRunning) {
      isTimerRunning = false;
      clearInterval(timerInterval);
      startBtn.classList.remove('pulse-animation');
    }
  }

  function resetTimer() {
    pauseTimer();
    seconds = 0;
    minutes = 0;
    updateTimerDisplay();
  }

  function updateTimer() {
    seconds++;
    if (seconds >= 60) {
      seconds = 0;
      minutes++;
    }
    updateTimerDisplay();
  }

  function updateTimerDisplay() {
    timerElement.textContent = `${padZero(minutes)}:${padZero(seconds)}`;
  }

  function padZero(number) {
    return number < 10 ? `0${number}` : number;
  }

  // Button event listeners
  startBtn.addEventListener('click', startTimer);
  pauseBtn.addEventListener('click', pauseTimer);
  
  revealBtn.addEventListener('click', function() {
    if (!answerRevealed) {
      // Highlight the correct answer
      answerOptions.forEach(option => {
        if (option.dataset.option === correctAnswer) {
          option.classList.add('glow-effect');
          option.style.backgroundColor = 'rgba(16, 185, 129, 0.3)'; // Highlight with success color
        }
      });
      answerRevealed = true;
      pauseTimer();
    } else {
      // Reset highlighting
      answerOptions.forEach(option => {
        option.classList.remove('glow-effect');
        option.style.backgroundColor = '';
      });
      answerRevealed = false;
    }
  });

  // Question selection
  questionItems.forEach(item => {
    item.addEventListener('change', function() {
      if (this.checked) {
        currentQuestion = this.value;
        loadQuestion(currentQuestion);
        // Reset answer highlighting
        answerOptions.forEach(option => {
          option.classList.remove('glow-effect');
          option.style.backgroundColor = '';
        });
        answerRevealed = false;
        
        // Update the question number badge
        document.querySelector('.question-badge').textContent = currentQuestion;
        
        // Update active prize level
        updatePrizeLevel(currentQuestion);
      }
    });
  });

  // Sample questions data (would be loaded from database)
  const questions = [
    {
      id: 1,
      text: 'Đâu là ngôn ngữ chính thức được sử dụng ở vương quốc Anh?',
      answers: ['Tiếng Anh', 'Tiếng Pháp', 'Tiếng Nga', 'Tiếng Đức'],
      correct: 'A',
      money: 100
    },
    {
      id: 2,
      text: 'Thủ đô của Việt Nam là gì?',
      answers: ['Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Hải Phòng'],
      correct: 'B',
      money: 200
    },
    {
      id: 3,
      text: 'Trái đất quay quanh mặt trời trong bao nhiêu ngày?',
      answers: ['365 ngày', '366 ngày', '364 ngày', '360 ngày'],
      correct: 'A',
      money: 300
    },
    {
      id: 4,
      text: 'Đơn vị đo thể tích nào sau đây là lớn nhất?',
      answers: ['Gallon', 'Lít', 'Pint', 'Mililít'],
      correct: 'A',
      money: 500
    },
    {
      id: 5,
      text: 'Ai là người đầu tiên đặt chân lên mặt trăng?',
      answers: ['Yuri Gagarin', 'Neil Armstrong', 'Buzz Aldrin', 'Alan Shepard'],
      correct: 'B',
      money: 1000
    },
    {
      id: 6,
      text: 'Quốc gia nào có diện tích lớn nhất thế giới?',
      answers: ['Nga', 'Canada', 'Trung Quốc', 'Mỹ'],
      correct: 'A',
      money: 2000
    },
    {
      id: 7,
      text: 'Bộ phim nào đạt doanh thu cao nhất mọi thời đại?',
      answers: ['Avatar', 'Avengers: Endgame', 'Titanic', 'Star Wars: The Force Awakens'],
      correct: 'B',
      money: 4000
    },
    {
      id: 8,
      text: 'Năm bao nhiêu Việt Nam giành độc lập?',
      answers: ['1945', '1954', '1975', '1986'],
      correct: 'A',
      money: 8000
    },
    {
      id: 9,
      text: 'Hành tinh nào gần mặt trời nhất?',
      answers: ['Trái đất', 'Sao Kim', 'Sao Thủy', 'Sao Hỏa'],
      correct: 'C',
      money: 16000
    },
    {
      id: 10,
      text: 'Ai là tác giả của "Romeo và Juliet"?',
      answers: ['Charles Dickens', 'William Shakespeare', 'Jane Austen', 'Mark Twain'],
      correct: 'B',
      money: 32000
    }
  ];

  // Load question data
  function loadQuestion(id) {
    const question = questions.find(q => q.id === parseInt(id)) || questions[0];
    
    questionText.textContent = question.text;
    correctAnswer = question.correct;
    currentMoney.textContent = question.money;
    
    // Update answers
    answerOptions.forEach((option, index) => {
      const answerText = option.querySelector('.answer-text');
      answerText.textContent = question.answers[index];
    });
    
    resetTimer();
  }
  
  // Update active prize level
  function updatePrizeLevel(level) {
    const prizeItems = document.querySelectorAll('.prize-item');
    prizeItems.forEach(item => {
      item.classList.remove('active');
      if (parseInt(item.textContent) === parseInt(level)) {
        item.classList.add('active');
      }
    });
  }
  
  // Answer option click events
  answerOptions.forEach(option => {
    option.addEventListener('click', function() {
      if (!answerRevealed) {
        const selectedOption = this.dataset.option;
        
        // Clear any previous selections
        answerOptions.forEach(opt => {
          opt.classList.remove('selected');
          opt.classList.remove('glow-effect');
          opt.style.backgroundColor = '';
        });
        
        // Mark this option as selected
        this.classList.add('selected');
        
        // Visual feedback
        if (selectedOption === correctAnswer) {
          this.classList.add('glow-effect');
          this.style.backgroundColor = 'rgba(16, 185, 129, 0.3)';
        } else {
          this.style.backgroundColor = 'rgba(239, 68, 68, 0.3)';
          
          // Also highlight the correct answer
          answerOptions.forEach(opt => {
            if (opt.dataset.option === correctAnswer) {
              opt.classList.add('glow-effect');
              opt.style.backgroundColor = 'rgba(16, 185, 129, 0.3)';
            }
          });
        }
        
        answerRevealed = true;
        pauseTimer();
      }
    });
  });
  
  // Initialize
  loadQuestion(currentQuestion);
  updatePrizeLevel(currentQuestion);
});
