
import React from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { 
  Home, ShoppingCart, DollarSign, Globe, LineChart, Music, 
  Layout, Calendar, Kanban, LogOut
} from 'lucide-react';

interface SidebarItemProps {
  icon: React.ElementType;
  label: string;
  active?: boolean;
  onClick?: () => void;
}

const SidebarItem: React.FC<SidebarItemProps> = ({ 
  icon: Icon, label, active, onClick 
}) => {
  return (
    <button 
      onClick={onClick}
      className={`sidebar-item ${active ? 'active' : ''} animate-fade-in`}
    >
      <Icon size={20} />
      <span>{label}</span>
    </button>
  );
};

const Sidebar: React.FC = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const pathname = location.pathname;

  const isActive = (path: string) => {
    return pathname === path;
  };

  return (
    <div className="w-[250px] min-h-screen bg-sidebar border-r border-slate-200 flex flex-col py-5 px-3">
      {/* Logo */}
      <div className="flex items-center gap-2 px-3 mb-8">
        <div className="flex items-center">
          <div className="w-8 h-8 bg-brand-blue rounded-md flex items-center justify-center">
            <div className="w-4 h-4 bg-white rounded-sm"></div>
          </div>
        </div>
        <h1 className="text-xl font-semibold">Modernize</h1>
      </div>
      
      {/* Navigation Sections */}
      <div className="space-y-1 px-2">
        <p className="text-xs font-semibold text-slate-500 mb-1 px-3">HOME</p>
        <div className="flex flex-col">
          <SidebarItem 
            icon={Home} 
            label="Modern" 
            active={isActive('/')} 
            onClick={() => navigate('/')}
          />
          <SidebarItem 
            icon={ShoppingCart} 
            label="eCommerce" 
            active={isActive('/ecommerce')} 
            onClick={() => navigate('/ecommerce')}
          />
          <SidebarItem 
            icon={DollarSign} 
            label="NFT" 
            active={isActive('/nft')} 
            onClick={() => navigate('/nft')}
          />
          <SidebarItem 
            icon={Globe} 
            label="Crypto" 
            active={isActive('/crypto')} 
            onClick={() => navigate('/crypto')}
          />
          <SidebarItem 
            icon={LineChart} 
            label="General" 
            active={isActive('/general')} 
            onClick={() => navigate('/general')}
          />
          <SidebarItem 
            icon={Music} 
            label="Music" 
            active={isActive('/music')} 
            onClick={() => navigate('/music')}
          />
          <SidebarItem 
            icon={Layout} 
            label="Frontend page" 
            active={isActive('/frontend')} 
            onClick={() => navigate('/frontend')}
          />
        </div>
      </div>
      
      <div className="mt-8 space-y-1 px-2">
        <p className="text-xs font-semibold text-slate-500 mb-1 px-3">APPS</p>
        <div className="flex flex-col">
          <SidebarItem 
            icon={Calendar} 
            label="Calendar" 
            active={isActive('/calendar')} 
            onClick={() => navigate('/calendar')}
          />
          <SidebarItem 
            icon={Kanban} 
            label="Kanban" 
            active={isActive('/kanban')} 
            onClick={() => navigate('/kanban')}
          />
        </div>
      </div>
      
      {/* User Profile */}
      <div className="mt-auto mx-2 mb-2 p-3 bg-slate-100 rounded-xl flex items-center">
        <div className="w-10 h-10 rounded-full overflow-hidden bg-brand-blue flex items-center justify-center text-white font-medium text-sm">
          M
        </div>
        <div className="ml-3 flex-1">
          <p className="text-sm font-medium">Mathew</p>
          <p className="text-xs text-slate-500">Designer</p>
        </div>
        <button className="w-8 h-8 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors">
          <LogOut size={18} />
        </button>
      </div>
    </div>
  );
};

export default Sidebar;
