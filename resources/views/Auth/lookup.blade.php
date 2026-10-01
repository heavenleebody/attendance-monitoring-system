<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campus Room Reservation — Student Number</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --maroon: #660009;
            --maroon-dark: #4a0007;
            --cream: #f7f0e0;
            --tan: #ecdcb0;
            --line: #d9cfb8;
            --text: #2b2b2b;
            --muted: #7a7466;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 20px; font-family: 'Poppins', system-ui, sans-serif; color: var(--text);
            background-color: var(--tan);
            background-image:
                linear-gradient(rgba(102,0,9,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(102,0,9,.06) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* Main card */
        .card {
            background: var(--cream); border: 2px solid var(--maroon); border-radius: 6px;
            padding: 64px 40px 50px; width: 100%; max-width: 560px; text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,.18);
        }
        .card h1 {
            margin: 0 0 8px; font-size: 26px; font-weight: 700; letter-spacing: 4px;
            text-transform: uppercase; color: var(--maroon);
        }
        .card p.sub { margin: 0 0 30px; font-size: 14px; color: var(--muted); }

        label.lbl {
            display: block; text-align: left; font-size: 11px; font-weight: 500;
            letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-bottom: 8px;
        }

        /* Input with blinking horizontal cursor */
        .field {
            position: relative; background: var(--cream); border: 1px solid var(--line);
            border-radius: 3px; padding: 0 16px; margin-bottom: 10px; text-align: left;
        }
        .field:focus-within { border-color: var(--maroon); }
        .field input {
            width: 100%; border: 0; outline: 0; background: transparent; caret-color: transparent;
            font: 500 22px/1 'Poppins', sans-serif; letter-spacing: 2px; color: var(--text);
            padding: 16px 0 22px;
        }
        .cursor {
            position: absolute; bottom: 14px; left: 16px; width: 16px; height: 3px;
            background: var(--maroon); animation: blink 1s steps(1) infinite; pointer-events: none;
        }
        @keyframes blink { 50% { opacity: 0; } }

        .divider { height: 1px; background: var(--line); margin: 16px 0 20px; }

        .hint { text-align: left; font-size: 12px; color: var(--muted); margin-top: 14px; margin-bottom: 8px; }

        .alert-box { max-width: 400px; }
        .alert-icon {
        width: 64px; height: 64px; margin: 0 auto 16px; border-radius: 50%;
        background: var(--maroon); color: #fff; font-size: 34px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        }
        .alert-box h2 { margin-bottom: 8px; font-size: 20px; }
        .alert-text { margin: 0 0 22px; font-size: 14px; color: var(--muted); }
        .close-btn {
            width: 100%; padding: 14px; border: 0; border-radius: 3px; cursor: pointer;
            background: var(--maroon); color: #fff;
            font: 600 13px 'Poppins', sans-serif; letter-spacing: 3px; text-transform: uppercase;
        }
        .close-btn:hover { background: var(--maroon-dark); }

        .register-btn {
            display: block; width: 100%; padding: 16px; border: 0; border-radius: 3px;
            background: var(--maroon); color: #fff; text-decoration: none; cursor: pointer;
            font: 600 13px 'Poppins', sans-serif; letter-spacing: 3px; text-transform: uppercase;
            transition: background .2s;
        }
        .register-btn:hover { background: var(--maroon-dark); }

        .card { position: relative; }

        .back-btn {
            position: absolute; top: 14px; left: 16px;
            padding: 6px 12px; border: 1px solid var(--maroon); border-radius: 3px;
            background: transparent; color: var(--maroon); text-decoration: none;
            font: 600 11px 'Poppins', sans-serif; letter-spacing: 2px; text-transform: uppercase;
            transition: background .2s, color .2s;
    
        }
        .back-btn:hover { background: var(--maroon); color: #fff; }

        /* Student page (overlay) */
        .overlay {
            position: fixed; inset: 0; background: rgba(40,30,20,.55); display: none;
            align-items: center; justify-content: center; padding: 20px; z-index: 50;
        }
        .overlay.show { display: flex; }
        .info {
            background: var(--cream); border: 2px solid var(--maroon); border-radius: 6px;
            padding: 36px 36px 28px; width: 100%; max-width: 460px; text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,.3);
        }
        .info h2 {
            margin: 0 0 20px; font-size: 24px; font-weight: 700; letter-spacing: 3px;
            text-transform: uppercase; color: var(--maroon);
        }
        .info img {
            width: 170px; height: 170px; object-fit: cover; border-radius: 50%;
            border: 4px solid var(--maroon); background: #ddd;
        }
        .info .num { margin-top: 18px; font-size: 20px; font-weight: 600; letter-spacing: 2px; color: var(--maroon); }
        .info .ysc { margin-top: 4px; font-size: 16px; font-weight: 500; color: var(--text); }
        .clock {
            margin-top: 20px; padding: 10px; border: 1px dashed var(--line); border-radius: 3px;
            font-size: 14px; color: var(--muted); font-variant-numeric: tabular-nums;
        }
        .bar-wrap { margin-top: 20px; height: 4px; background: var(--line); border-radius: 2px; overflow: hidden; }
        .bar { height: 100%; width: 100%; background: var(--maroon); transform-origin: left; }
        .bar.run { animation: shrink 5s linear forwards; }
        @keyframes shrink { from { transform: scaleX(1); } to { transform: scaleX(0); } }
    </style>
</head>
<body>

<div class="card">
    <a class="back-btn" href="{{ route('login') }}">&larr; Back to Login</a>

    <h1>Student Information</h1>
    <p class="sub">Enter Student ID to view student information.</p>

    <label class="lbl" for="studentNumber">Student ID</label>
    <div class="field">
        <input type="text" id="studentNumber" autocomplete="off" autofocus maxlength="50">
        <span class="cursor" id="cursor"></span>
    </div>

    <div class="divider"></div>
    
    <div class="hint">If Student ID is not registered, register first.</div>

    <a class="register-btn" href="{{ route('student.register') }}">Student Registration</a>

</div>

<!-- Student page (overlay) -->
<div class="overlay" id="overlay">
    <div class="info">
        <h2 id="sName"></h2>
        <img id="sPhoto" alt="Student photo">
        <div class="num" id="sNumber"></div>
        <div class="ysc" id="sYSC"></div>
        <div class="clock" id="clock"></div>
        <div class="bar-wrap"><div class="bar" id="bar"></div></div>
    </div>
</div>

<!-- No student found (pop up) -->
<div class="overlay" id="notFoundModal">
    <div class="info alert-box">
        <div class="alert-icon">!</div>
        <h2>No Student Found</h2>
        <p class="alert-text">Register student first.</p>
        <button type="button" class="close-btn" id="notFoundClose">OK</button>
    </div>
</div>

<script>
    const input    = document.getElementById('studentNumber');
    const cursor   = document.getElementById('cursor');
    const overlay  = document.getElementById('overlay');
    const notFoundModal = document.getElementById('notFoundModal');
    const notFoundClose = document.getElementById('notFoundClose');
    const bar      = document.getElementById('bar');
    const CHECK_URL = @json(route('student.check'));

    let clockInterval = null, overlayTimer = null, busy = false;

    // Blinking horizontal cursor that follows the text
    const measurer = document.createElement('span');
    measurer.style.cssText = 'position:absolute;visibility:hidden;white-space:pre;';
    document.body.appendChild(measurer);

    function moveCursor() {
        const cs = getComputedStyle(input);
        measurer.style.font = cs.font;
        measurer.style.letterSpacing = cs.letterSpacing;

        // measure only the text BEFORE the caret position
        const pos = input.selectionStart ?? input.value.length;
        measurer.textContent = input.value.substring(0, pos);

        const maxLeft = input.parentElement.clientWidth - 16 - 16;
        const left = 16 + measurer.offsetWidth - input.scrollLeft;
        cursor.style.left = Math.max(16, Math.min(left, maxLeft)) + 'px';
        cursor.style.display = document.activeElement === input ? 'block' : 'none';

        // restart the blink so the cursor stays solid while you're moving it
        cursor.style.animation = 'none';
        void cursor.offsetWidth;
        cursor.style.animation = '';
    }

    // Arrow keys move the caret AFTER keydown, so wait one frame before reading it
    input.addEventListener('keydown', () => requestAnimationFrame(moveCursor));
    ['input', 'focus', 'blur', 'keyup', 'click', 'mouseup', 'select'].forEach(e =>
        input.addEventListener(e, moveCursor));
    document.addEventListener('selectionchange', () => {
        if (document.activeElement === input) moveCursor();
    });
    moveCursor();
    document.querySelector('.card').addEventListener('click', e => {
        if (!e.target.closest('a')) input.focus();
    });

    // Press Enter to look up
    input.addEventListener('keydown', async e => {
        if (e.key !== 'Enter' || busy) return;
        const value = input.value.trim();
        if (!value) return;

        busy = true;

        try {
            const res  = await fetch(CHECK_URL + '?student_number=' + encodeURIComponent(value),
                                     { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (data.registered) showStudent(data.student);
            else showNotFound();
        } catch (err) {
            console.error(err);
        }
        busy = false;
    });

    function showNotFound() {
    notFoundModal.classList.add('show');
    notFoundClose.focus();   // so pressing Enter again closes it
    }

    function hideNotFound() {
        notFoundModal.classList.remove('show');
        input.focus();
        input.select();          // highlights the old number so you can retype right away
        moveCursor();
    }

    notFoundClose.addEventListener('click', hideNotFound);
    notFoundModal.addEventListener('click', e => { if (e.target === notFoundModal) hideNotFound(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && notFoundModal.classList.contains('show')) hideNotFound();
    });

    function showStudent(s) {
        document.getElementById('sName').textContent   = s.last_name + ', ' + s.first_name;
        document.getElementById('sPhoto').src          = s.photo_url;
        document.getElementById('sNumber').textContent = s.student_number;
        document.getElementById('sYSC').textContent    = s.year_level + ' - ' + s.section + ' ' + s.course;

        overlay.classList.add('show');
        tick();
        clearInterval(clockInterval);
        clockInterval = setInterval(tick, 1000);

        // restart the 5-second progress bar
        bar.classList.remove('run');
        void bar.offsetWidth;
        bar.classList.add('run');

        // Disappear after 5 seconds
        clearTimeout(overlayTimer);
        overlayTimer = setTimeout(() => {
            overlay.classList.remove('show');
            clearInterval(clockInterval);
            input.value = '';
            moveCursor();
            input.focus();
        }, 5000);
    }

    function tick() {
        document.getElementById('clock').textContent = new Date().toLocaleString('en-PH', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
    }
</script>
</body>
</html>