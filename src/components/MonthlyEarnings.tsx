
import React from 'react';
import { motion } from 'framer-motion';
import { DollarSign, Settings, TrendingUp } from 'lucide-react';

const MonthlyEarnings: React.FC = () => {
  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.97 }}
      animate={{ opacity: 1, scale: 1 }}
      transition={{ duration: 0.3, delay: 0.4 }}
      className="bg-white p-5 rounded-xl border border-slate-200 shadow-sm"
    >
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-semibold text-slate-800">Monthly Earnings</h2>
        <div className="flex items-center gap-2">
          <button className="w-8 h-8 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors relative group">
            <Settings size={18} className="transition-transform duration-700 ease-in-out group-hover:rotate-90" />
          </button>
          <button className="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
            <DollarSign size={18} />
          </button>
        </div>
      </div>
      
      <div className="mt-5">
        <h3 className="text-3xl font-bold text-slate-800">$6,820</h3>
        <div className="flex items-center mt-1 text-sm">
          <div className="flex items-center text-emerald-500 mr-2">
            <TrendingUp size={15} className="mr-1" />
            <span>+9%</span>
          </div>
          <span className="text-slate-500">last year</span>
        </div>
      </div>
      
      <div className="mt-5 flex">
        {[30, 60, 45, 75, 50, 40, 65].map((height, index) => (
          <div key={index} className="flex-1 flex items-end">
            <motion.div
              initial={{ height: 0 }}
              animate={{ height: `${height}px` }}
              transition={{ duration: 0.5, delay: 0.4 + (index * 0.1), ease: "easeOut" }}
              className="w-4 bg-blue-500 rounded-t-sm mx-auto opacity-80"
              style={{ 
                opacity: index === 3 ? '1' : '0.7',
                backgroundColor: index === 3 ? '#3b82f6' : '#93c5fd'
              }}
            ></motion.div>
          </div>
        ))}
      </div>
    </motion.div>
  );
};

export default MonthlyEarnings;
