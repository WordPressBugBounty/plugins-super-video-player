import { NavLink } from 'react-router-dom';

const Header = ({ navigation }) => {

  return (
    <div className="dashboard-heading-container">
      <div className="dashboard-heading">
        <div className="heading">
          <img className="block-logo" src="https://ps.w.org/super-video-player/assets/icon-128x128.png?rev=2562337" alt="CustomHtmlIcon" />
          <h1 className="heading-title"> Super Video Player </h1>
        </div>
        <div className="plugin-version"> v1.8.3 </div>
      </div>

      {/* Links */}
      <div className="navLinks">
        <div className='firstLinks'>
          {
            navigation.map((item, index) => {
              return (<NavLink key={index} to={item.href} className={`links ${({ isActive }) => isActive ? 'active' : ''}`}>
                {item.name} </NavLink>)
            })
          }
        </div>

      </div>
    </div>
  );
};

export default Header;