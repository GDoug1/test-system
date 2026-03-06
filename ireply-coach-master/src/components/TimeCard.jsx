import '../styles/TimeCard.css';

function TimeCard({
  autoTimeOut,
  setAutoTimeOut,
  timeInputDisplay,
  counterDisplay,
  timeInStart,
  onToggleTimeIn,
}) {
  return (
    <div className="card time-card">
      <div className="time-panel">
        <div className="time-panel-row">
          <span className="time-auto-label">AUTO-TIME OUT</span>
          <button
            type="button"
            className={`time-switch ${autoTimeOut ? 'on' : ''}`}
            aria-label="Auto time out"
            onClick={() => setAutoTimeOut((prev) => !prev)}
          >
            <span className="time-switch-knob" />
          </button>
        </div>

        <div className="time-input">{timeInputDisplay}</div>
        <div className="time-counter">{counterDisplay}</div>

        <button type="button" className="time-in-btn" onClick={onToggleTimeIn}>
          {timeInStart ? 'Time Out' : 'Time In'}
        </button>
      </div>
    </div>
  );
}

export default TimeCard;
