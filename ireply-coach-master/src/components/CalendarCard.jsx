import '../styles/CalendarCard.css';

function CalendarCard({ calendarData }) {
  return (
    <div className="card calendar-card">
      <div className="card-top">
        <span>Calendar</span>
        <span className="calendar-month">{calendarData.monthLabel}</span>
      </div>
      <div className="calendar-grid weekdays">
        {calendarData.weekDays.map((weekday) => (
          <div key={weekday} className="calendar-cell header">{weekday}</div>
        ))}
      </div>
      <div className="calendar-grid dates">
        {calendarData.cells.map((cell, index) => (
          <div
            key={`${cell.day}-${index}`}
            className={`calendar-cell ${cell.muted ? 'muted' : ''} ${cell.isToday ? 'today' : ''}`}
          >
            {cell.day}
          </div>
        ))}
      </div>
    </div>
  );
}

export default CalendarCard;
