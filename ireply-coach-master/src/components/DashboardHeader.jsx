import '../styles/DashboardHeader.css';

function DashboardHeader({ headerTime, headerDate }) {
  return (
    <section className="dashboard-header">
      <div className="dashboard-title-wrap">
        <h1>DASHBOARD</h1>
      </div>
      <div className="datetime">{headerTime}&nbsp;&nbsp;&nbsp;{headerDate}</div>
    </section>
  );
}

export default DashboardHeader;
