
import React, { useEffect, useRef } from 'react';
import { motion } from 'framer-motion';
import { TrendingUp } from 'lucide-react';

const YearlyBreakup: React.FC = () => {
  const circleRef = useRef<SVGCircleElement>(null);
  const percentage = 78; // Example percentage for circular progress
  
  useEffect(() => {
    if (circleRef.current) {
      const radius = circleRef.current.r.baseVal.value;
      const circumference = radius * 2 * Math.PI;
      
      circleRef.current.style.strokeDasharray = `${circumference} ${circumference}`;
      circleRef.current.style.strokeDashoffset = `${circumference}`;
      
      const offset = circumference - (percentage / 100) * circumference;
      // Delay the animation slightly for visual effect
      setTimeout(() => {
        if (circleRef.current) {
          circleRef.current.style.strokeDashoffset = offset.toString();
        }
      }, 300);
    }
  }, [percentage]);
  
  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.97 }}
      animate={{ opacity: 1, scale: 1 }}
      transition={{ duration: 0.3, delay: 0.3 }}
      className="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col h-full"
    >
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-semibold text-slate-800">Yearly Breakup</h2>
      </div>
      
      <div className="mt-4">
        <h3 className="text-3xl font-bold text-slate-800">$36,358</h3>
        <div className="flex items-center mt-1 text-sm">
          <div className="flex items-center text-emerald-500 mr-2">
            <TrendingUp size={15} className="mr-1" />
            <span>+9%</span>
          </div>
          <span className="text-slate-500">last year</span>
        </div>
      </div>
      
      <div className="flex-1 flex items-center justify-center mt-4">
        <div className="relative w-36 h-36">
          <svg width="140" height="140" viewBox="0 0 140 140" className="transform -rotate-90">
            <circle className="progress-circle-bg" cx="70" cy="70" r="60" />
            <circle 
              ref={circleRef}
              className="progress-circle" 
              cx="70" 
              cy="70" 
              r="60" 
              stroke="#3b82f6"
            />
          </svg>
          <div className="absolute inset-0 flex flex-col items-center justify-center">
            <div className="flex space-x-1">
              <div className="w-2 h-2 rounded-full bg-blue-500"></div>
              <span className="text-xs font-medium">2024</span>
            </div>
          </div>
        </div>
      </div>
    </motion.div>
  );
};

export default YearlyBreakup;
