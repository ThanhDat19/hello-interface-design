
// DOM Elements
const participantsSidebar = document.getElementById('participantsSidebar');
const showParticipantsBtn = document.getElementById('showParticipants');
const closeSidebarBtn = document.getElementById('closeSidebar');
const timerElement = document.getElementById('timer');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const revealBtn = document.getElementById('revealBtn');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const questionItems = document.querySelectorAll('.question-item input');
const answerOptions = document.querySelectorAll('.answer-option');

// Variables
let timer;
let seconds = 0;
let isPaused = true;
let currentQuestion = 1;
const totalQuestions = 10; // Tổng số câu hỏi

// Khởi tạo danh sách thí sinh
const initParticipants = () => {
  const participantsGrid = document.querySelector('.participants-grid');
  participantsGrid.innerHTML = '';
  
  // Tạo 60 thí sinh
  for (let i = 1; i <= 60; i++) {
    const participant = document.createElement('div');
    participant.className = 'participant';
    participant.textContent = i;
    participant.setAttribute('data-id', i);
    
    participant.addEventListener('click', () => {
      participant.classList.toggle('active');
    });
    
    participantsGrid.appendChild(participant);
  }
};

// Xử lý hiển thị sidebar
const toggleSidebar = () => {
  participantsSidebar.classList.toggle('active');
  
  // Thêm overlay khi sidebar mở
  let overlay = document.querySelector('.overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.className = 'overlay';
    document.body.appendChild(overlay);
    
    overlay.addEventListener('click', () => {
      participantsSidebar.classList.remove('active');
      overlay.classList.remove('active');
    });
  }
  
  overlay.classList.toggle('active');
};

// Định dạng thời gian
const formatTime = (totalSeconds) => {
  const minutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
  const seconds = (totalSeconds % 60).toString().padStart(2, '0');
  return `${minutes}:${seconds}`;
};

// Bộ đếm thời gian
const startTimer = () => {
  if (!timer) {
    timer = setInterval(() => {
      if (!isPaused) {
        seconds++;
        timerElement.textContent = formatTime(seconds);
      }
    }, 1000);
  }
};

// Tạm dừng bộ đếm thời gian
const pauseTimer = () => {
  isPaused = !isPaused;
  pauseBtn.innerHTML = isPaused ? 
    `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polygon points="5 3 19 12 5 21 5 3"></polygon>
    </svg>
    <span>Tiếp tục</span>` : 
    `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="6" y="4" width="4" height="16"></rect>
      <rect x="14" y="4" width="4" height="16"></rect>
    </svg>
    <span>Tạm dừng</span>`;
};

// Reset bộ đếm thời gian
const resetTimer = () => {
  clearInterval(timer);
  timer = null;
  seconds = 0;
  isPaused = true;
  timerElement.textContent = formatTime(seconds);
};

// Hiển thị đáp án
const revealAnswer = () => {
  document.querySelector('.correct-answer').classList.add('fade-in');
  document.querySelector('.correct-answer').style.display = 'block';
};

// Chuyển câu hỏi
const changeQuestion = (direction) => {
  if (direction === 'next' && currentQuestion < totalQuestions) {
    currentQuestion++;
  } else if (direction === 'prev' && currentQuestion > 1) {
    currentQuestion--;
  }
  
  // Cập nhật radio button
  questionItems.forEach(item => {
    if (parseInt(item.value) === currentQuestion) {
      item.checked = true;
    }
  });
  
  // Cập nhật tiêu đề và nội dung câu hỏi
  document.querySelector('.question-title').textContent = `Câu hỏi ${currentQuestion}:`;
  document.querySelector('.question-text').textContent = `Nội dung câu hỏi ${currentQuestion}...`;
  
  // Ẩn đáp án khi chuyển câu hỏi
  document.querySelector('.correct-answer').style.display = 'none';
};

// Sự kiện
showParticipantsBtn.addEventListener('click', toggleSidebar);
closeSidebarBtn.addEventListener('click', toggleSidebar);

startBtn.addEventListener('click', () => {
  resetTimer();
  startTimer();
  isPaused = false;
  pauseBtn.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="6" y="4" width="4" height="16"></rect>
      <rect x="14" y="4" width="4" height="16"></rect>
    </svg>
    <span>Tạm dừng</span>`;
  document.querySelector('.correct-answer').style.display = 'none';
});

pauseBtn.addEventListener('click', pauseTimer);
revealBtn.addEventListener('click', revealAnswer);
prevBtn.addEventListener('click', () => changeQuestion('prev'));
nextBtn.addEventListener('click', () => changeQuestion('next'));

// Chọn câu hỏi từ sidebar
questionItems.forEach(item => {
  item.addEventListener('change', () => {
    currentQuestion = parseInt(item.value);
    changeQuestion();
  });
});

// Sự kiện cho các đáp án
answerOptions.forEach(option => {
  option.addEventListener('click', () => {
    // Loại bỏ lớp active từ tất cả các đáp án
    answerOptions.forEach(opt => opt.classList.remove('active'));
    // Thêm lớp active cho đáp án được chọn
    option.classList.add('active');
  });
});

// Khởi tạo ứng dụng
const init = () => {
  initParticipants();
  document.querySelector('.correct-answer').style.display = 'none';
};

// Gọi hàm khởi tạo khi trang được tải
document.addEventListener('DOMContentLoaded', init);

// Bắt sự kiện phím
document.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    revealAnswer();
  } else if (e.key === 'ArrowRight') {
    changeQuestion('next');
  } else if (e.key === 'ArrowLeft') {
    changeQuestion('prev');
  } else if (e.key === ' ') { // Space
    pauseTimer();
  }
});
