import { useEffect, useMemo, useState } from 'react';
import './styles/App.css';
import logo from './ireply-logo.png';
import Sidebar from './components/Sidebar';
import DashboardHeader from './components/DashboardHeader';
import TimeCard from './components/TimeCard';
import AnnouncementCard from './components/AnnouncementCard';
import BreakCard from './components/BreakCard';
import ShiftCard from './components/ShiftCard';
import CalendarCard from './components/CalendarCard';
import HolidayCard from './components/HolidayCard';
import SummaryCard from './components/SummaryCard';
import MemberStatusCard from './components/MemberStatusCard';

const API_BASE_URL = 'http://localhost/timelogger/api';
const CURRENT_USER_ID = 1; // tester1
const CURRENT_EMPLOYEE_ID = 1;
const CURRENT_CLUSTER_ID = 1;

function App() {
  const [now, setNow] = useState(new Date());
  const [autoTimeOut, setAutoTimeOut] = useState(false);
  const [timeInStart, setTimeInStart] = useState(null);
  const [announcements, setAnnouncements] = useState([]);
  const [holidays, setHolidays] = useState([]);
  const [schedule, setSchedule] = useState(null);
  const [todaysLog, setTodaysLog] = useState(null);
  const [userData, setUserData] = useState(null);
  const [memberStatuses, setMemberStatuses] = useState([]);
  const [loading, setLoading] = useState(true);

  // Fetch user data
  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const response = await fetch(`${API_BASE_URL}/get_user_data.php?user_id=${CURRENT_USER_ID}`);
        const result = await response.json();
        if (result.status === 'success') {
          setUserData(result.data);
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    };
    fetchUserData();
  }, []);

  // Fetch announcements
  useEffect(() => {
    const fetchAnnouncements = async () => {
      try {
        const response = await fetch(`${API_BASE_URL}/get_announcements.php`);
        const result = await response.json();
        if (result.status === 'success') {
          setAnnouncements(result.data);
        }
      } catch (error) {
        console.error('Error fetching announcements:', error);
      }
    };
    fetchAnnouncements();
  }, []);

  // Fetch holidays
  useEffect(() => {
    const fetchHolidays = async () => {
      try {
        const response = await fetch(`${API_BASE_URL}/get_holidays.php`);
        const result = await response.json();
        if (result.status === 'success') {
          setHolidays(result.data);
        }
      } catch (error) {
        console.error('Error fetching holidays:', error);
      }
    };
    fetchHolidays();
  }, []);

  // Fetch schedule
  useEffect(() => {
    const fetchSchedule = async () => {
      try {
        const response = await fetch(`${API_BASE_URL}/get_schedules.php?employee_id=${CURRENT_EMPLOYEE_ID}`);
        const result = await response.json();
        if (result.status === 'success') {
          setSchedule(result.data);
        }
      } catch (error) {
        console.error('Error fetching schedule:', error);
      }
    };
    fetchSchedule();
  }, []);

  // Fetch todays log
  useEffect(() => {
    const fetchTodaysLog = async () => {
      try {
        const response = await fetch(`${API_BASE_URL}/get_todays_log.php?employee_id=${CURRENT_EMPLOYEE_ID}`);
        const result = await response.json();
        if (result.status === 'success') {
          setTodaysLog(result.data);
        }
      } catch (error) {
        console.error('Error fetching todays log:', error);
      }
    };
    fetchTodaysLog();
  }, []);

  // Fetch member status
  useEffect(() => {
    const fetchMemberStatus = async () => {
      try {
        const response = await fetch(`${API_BASE_URL}/get_member_status.php?cluster_id=${CURRENT_CLUSTER_ID}`);
        const result = await response.json();
        if (result.status === 'success') {
          setMemberStatuses(result.data);
          setLoading(false);
        }
      } catch (error) {
        console.error('Error fetching member status:', error);
        setLoading(false);
      }
    };
    fetchMemberStatus();
  }, []);

  // Update time every second
  useEffect(() => {
    const timer = setInterval(() => {
      setNow(new Date());
    }, 1000);
    return () => clearInterval(timer);
  }, []);

  // Handle Time In/Out
  const handleToggleTimeIn = async () => {
    if (!timeInStart) {
      // Time In
      setTimeInStart(new Date());
      try {
        const response = await fetch(`${API_BASE_URL}/time_in_out.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            user_id: CURRENT_USER_ID,
            employee_id: CURRENT_EMPLOYEE_ID,
            action: 'time_in',
            timestamp: new Date().toISOString().slice(0, 19).replace('T', ' ')
          })
        });
        const result = await response.json();
        console.log('[v0] Time In response:', result);
        if (result.status !== 'success') {
          console.error('Time In error:', result.message);
          alert(`Error: ${result.message}`);
        }
      } catch (error) {
        console.error('[v0] Error recording time in:', error);
        alert(`Network error: ${error.message}`);
      }
    } else {
      // Time Out
      try {
        const response = await fetch(`${API_BASE_URL}/time_in_out.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            user_id: CURRENT_USER_ID,
            employee_id: CURRENT_EMPLOYEE_ID,
            action: 'time_out',
            timestamp: new Date().toISOString().slice(0, 19).replace('T', ' ')
          })
        });
        const result = await response.json();
        console.log('[v0] Time Out response:', result);
        if (result.status === 'success') {
          setTimeInStart(null);
          // Refresh today's log
          const logResponse = await fetch(`${API_BASE_URL}/get_todays_log.php?employee_id=${CURRENT_EMPLOYEE_ID}`);
          const logResult = await logResponse.json();
          if (logResult.status === 'success') {
            setTodaysLog(logResult.data);
          }
        } else {
          console.error('Time Out error:', result.message);
          alert(`Error: ${result.message}`);
        }
      } catch (error) {
        console.error('[v0] Error recording time out:', error);
        alert(`Network error: ${error.message}`);
      }
    }
  };

  // Format time display
  const headerTime = now.toLocaleTimeString('en-US', {
    hour: 'numeric',
    minute: '2-digit',
    second: '2-digit',
    hour12: true,
  });

  const liveClockTime = now.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: true,
  });

  const headerDate = now.toLocaleDateString('en-US', {
    weekday: 'short',
    month: 'long',
    day: 'numeric',
    year: 'numeric',
  });

  const elapsedSeconds = timeInStart ? Math.floor((now.getTime() - timeInStart.getTime()) / 1000) : 0;
  const hours = String(Math.floor(elapsedSeconds / 3600)).padStart(2, '0');
  const minutes = String(Math.floor((elapsedSeconds % 3600) / 60)).padStart(2, '0');
  const seconds = String(elapsedSeconds % 60).padStart(2, '0');
  const timerDisplay = `${hours}:${minutes}:${seconds}`;
  const liveCounterTime = now.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false,
  });
  const counterDisplay = timeInStart ? timerDisplay : liveCounterTime;
  const timeInputDisplay = timeInStart
    ? `Started: ${timeInStart.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })}`
    : liveClockTime;

  const calendarData = useMemo(() => {
    const currentMonth = now.getMonth();
    const currentYear = now.getFullYear();
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
    const cells = [];

    for (let day = firstDay - 1; day >= 0; day -= 1) {
      cells.push({ day: daysInPrevMonth - day, muted: true });
    }

    for (let day = 1; day <= daysInMonth; day += 1) {
      const isToday =
        day === now.getDate() &&
        currentMonth === new Date().getMonth() &&
        currentYear === new Date().getFullYear();
      cells.push({ day, muted: false, isToday });
    }

    while (cells.length < 42) {
      const day = cells.length - (firstDay + daysInMonth) + 1;
      cells.push({ day, muted: true });
    }

    return {
      monthLabel: now.toLocaleDateString('en-US', { month: 'long', year: 'numeric' }),
      weekDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      cells,
    };
  }, [now]);

  const totalHours = (elapsedSeconds / 3600).toFixed(1);

  const memberRequests = [
    { name: 'Kim Santos', request: 'Requesting OT' },
  ];

  const getStatusDotClass = (status) => {
    if (status === 'Absent') return 'dot red';
    if (status === 'Present') return 'dot green';
    if (status === 'Completed') return 'dot blue';
    return 'dot black';
  };

  if (loading) {
    return <div className="app-shell"><main className="content"><p>Loading...</p></main></div>;
  }

  return (
    <div className="app-shell">
      <Sidebar logo={logo} />

      <main className="content">
        <DashboardHeader headerTime={headerTime} headerDate={headerDate} />

        <section className="dashboard-grid">
          <TimeCard
            autoTimeOut={autoTimeOut}
            setAutoTimeOut={setAutoTimeOut}
            timeInputDisplay={timeInputDisplay}
            counterDisplay={counterDisplay}
            timeInStart={timeInStart}
            onToggleTimeIn={handleToggleTimeIn}
          />
          <AnnouncementCard announcements={announcements} />
          <BreakCard />
          <ShiftCard schedule={schedule} />
          <CalendarCard calendarData={calendarData} />
          <HolidayCard holidayBirthdayItems={holidays} />
          <SummaryCard timeInStart={timeInStart} totalHours={totalHours} />
          <MemberStatusCard
            memberStatuses={memberStatuses}
            memberRequests={memberRequests}
            getStatusDotClass={getStatusDotClass}
            timeInStart={timeInStart}
          />
        </section>
      </main>
    </div>
  );
}

export default App;
