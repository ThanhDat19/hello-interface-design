
import React, { useState } from 'react';
import { Search, Menu, ChevronDown, Moon } from 'lucide-react';

const Navbar: React.FC = () => {
  const [searchFocused, setSearchFocused] = useState(false);
  
  return (
    <div className="h-16 flex items-center justify-between px-6 border-b border-slate-200">
      <div className="flex items-center">
        <button className="w-9 h-9 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors">
          <Menu size={20} />
        </button>
        
        <div className={`relative ml-5 transition-all duration-300 ${searchFocused ? 'w-[300px]' : 'w-[200px]'}`}>
          <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <Search size={18} className="text-slate-400" />
          </div>
          <input
            type="search"
            className="w-full py-2 pl-10 pr-4 bg-slate-50 rounded-lg border border-slate-200 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-all duration-200"
            placeholder="Search..."
            onFocus={() => setSearchFocused(true)}
            onBlur={() => setSearchFocused(false)}
          />
        </div>
      </div>
      
      <div className="flex items-center gap-3">
        <nav className="hidden lg:flex mr-5 space-x-1">
          <button className="px-3 py-1.5 text-sm font-medium rounded hover:bg-slate-100">Apps</button>
          <button className="px-3 py-1.5 text-sm font-medium rounded hover:bg-slate-100">Chat</button>
          <button className="px-3 py-1.5 text-sm font-medium rounded hover:bg-slate-100">Calendar</button>
          <button className="px-3 py-1.5 text-sm font-medium rounded hover:bg-slate-100">Email</button>
        </nav>
        
        <button className="w-9 h-9 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors">
          <Moon size={18} />
        </button>
      </div>
    </div>
  );
};

export default Navbar;
