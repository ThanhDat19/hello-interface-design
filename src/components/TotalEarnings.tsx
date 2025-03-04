
import React from 'react';
import { motion } from 'framer-motion';
import { ArrowRight } from 'lucide-react';

const TotalEarnings: React.FC = () => {
  return (
    <motion.div 
      initial={{ opacity: 0, scale: 0.97 }}
      animate={{ opacity: 1, scale: 1 }}
      transition={{ duration: 0.3, delay: 0.2 }}
      className="bg-white p-5 rounded-xl border border-slate-200 shadow-sm"
    >
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-semibold text-slate-800">Total Earnings</h2>
        <div className="flex items-center gap-2">
          <div className="bg-blue-50 w-8 h-8 flex items-center justify-center rounded-md">
            <div className="w-5 h-5 rounded grid grid-cols-2 gap-0.5">
              <div className="bg-blue-200 rounded-tl"></div>
              <div className="bg-blue-300 rounded-tr"></div>
              <div className="bg-blue-300 rounded-bl"></div>
              <div className="bg-blue-500 rounded-br"></div>
            </div>
          </div>
        </div>
      </div>
      
      <div className="mt-6">
        <h3 className="text-3xl font-bold text-slate-800">$63,489.50</h3>
      </div>
      
      <button className="mt-6 text-brand-blue flex items-center text-sm font-medium hover:underline transition-all">
        <span>View Full Report</span>
        <ArrowRight size={16} className="ml-1" />
      </button>
    </motion.div>
  );
};

export default TotalEarnings;
