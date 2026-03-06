import '../styles/Sidebar.css';

function Sidebar({ logo }) {
  return (
    <aside className="sidebar">
      <div className="sidebar-top">
        <div className="brand">
          <img src={logo} alt="iREPLY logo" className="sidebar-logo" />
        </div>

        <div className="profile-logo" aria-label="Profile logo">
          <div className="profile-head" />
          <div className="profile-body" />
        </div>

        <div className="user-name">DLGG</div>

        <nav className="nav-menu">
          <button type="button" className="nav-item active">Dashboard</button>
          <button type="button" className="nav-item">Team</button>
          <button type="button" className="nav-item">Attendance</button>
        </nav>
      </div>

      <button type="button" className="logout-btn">Log Out</button>
    </aside>
  );
}

export default Sidebar;
