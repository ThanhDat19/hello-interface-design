
import React, { useEffect, useRef } from 'react';
import { 
  AreaChart, Area, BarChart, Bar, XAxis, YAxis, CartesianGrid, 
  Tooltip, ResponsiveContainer, Legend 
} from 'recharts';

const data = [
  { date: '14/08', value: 1.2, expense: -2.1 },
  { date: '15/08', value: 2.3, expense: -1.8 },
  { date: '16/08', value: 2.0, expense: -2.4 },
  { date: '17/08', value: 4.8, expense: -1.6 },
  { date: '18/08', value: 1.8, expense: -2.2 },
  { date: '19/08', value: 1.5, expense: -1.9 },
  { date: '20/08', value: 0, expense: 0 },
];

const RevenueChart: React.FC = () => {
  return (
    <div className="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
      <div className="flex justify-between items-start mb-4">
        <div>
          <h2 className="text-lg font-semibold text-slate-800">Revenue Updates</h2>
          <p className="text-sm text-slate-500">Overview of Profit</p>
        </div>
        <div className="flex items-center text-sm">
          <div className="px-3 py-1.5 bg-slate-100 rounded-md flex items-center">
            <span className="mr-1">March 2024</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </div>
        </div>
      </div>
      
      <div className="h-[250px] mt-6">
        <ResponsiveContainer width="100%" height="100%">
          <BarChart data={data} margin={{ top: 0, right: 0, left: 0, bottom: 0 }}>
            <defs>
              <linearGradient id="colorValue" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%" stopColor="#3b82f6" stopOpacity={0.9}/>
                <stop offset="95%" stopColor="#3b82f6" stopOpacity={0.4}/>
              </linearGradient>
              <linearGradient id="colorExpense" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%" stopColor="#60a5fa" stopOpacity={0.9}/>
                <stop offset="95%" stopColor="#60a5fa" stopOpacity={0.4}/>
              </linearGradient>
            </defs>
            <CartesianGrid strokeDasharray="3 3" vertical={false} strokeOpacity={0.2} />
            <XAxis 
              dataKey="date" 
              axisLine={false}
              tickLine={false}
              tickMargin={10}
              fontSize={12}
              stroke="#9ca3af"
            />
            <YAxis 
              axisLine={false} 
              tickLine={false}
              tickMargin={10}
              fontSize={12}
              stroke="#9ca3af"
              domain={[-4, 5]}
            />
            <Tooltip 
              contentStyle={{ 
                borderRadius: '8px',
                boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
                border: 'none',
                padding: '10px'
              }}
              labelStyle={{ marginBottom: '5px', fontWeight: 500 }}
            />
            <Bar dataKey="value" fill="url(#colorValue)" radius={[8, 8, 0, 0]} />
            <Bar dataKey="expense" fill="url(#colorExpense)" radius={[0, 0, 8, 8]} />
          </BarChart>
        </ResponsiveContainer>
      </div>
      
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10">
        <div>
          <div className="flex items-center mb-2">
            <div className="w-3 h-3 rounded-full bg-brand-blue mr-2"></div>
            <span className="text-sm text-slate-600">Earnings this month</span>
          </div>
          <p className="text-2xl font-semibold ml-5">$48,820</p>
        </div>
        <div>
          <div className="flex items-center mb-2">
            <div className="w-3 h-3 rounded-full bg-brand-lightBlue mr-2"></div>
            <span className="text-sm text-slate-600">Expense this month</span>
          </div>
          <p className="text-2xl font-semibold ml-5">$26,498</p>
        </div>
      </div>
    </div>
  );
};

export default RevenueChart;
