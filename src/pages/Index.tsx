
import React, { useEffect } from 'react';
import Sidebar from '../components/Sidebar';
import Navbar from '../components/Navbar';
import StatsCard from '../components/StatsCard';
import RevenueChart from '../components/RevenueChart';
import TotalEarnings from '../components/TotalEarnings';
import YearlyBreakup from '../components/YearlyBreakup';
import MonthlyEarnings from '../components/MonthlyEarnings';
import { toast } from 'sonner';
import { motion } from 'framer-motion';

const Index: React.FC = () => {
  useEffect(() => {
    // Show welcome toast on first render
    toast.success('Welcome to the dashboard', {
      description: 'Your analytics data has been updated',
      duration: 5000,
    });
  }, []);

  return (
    <div className="flex min-h-screen bg-slate-50">
      <Sidebar />
      
      <div className="flex-1 flex flex-col">
        <Navbar />
        
        <main className="flex-1 p-6">
          <div className="max-w-[1500px] mx-auto">
            {/* Stats Cards */}
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mb-6 stagger-animate"
            >
              <StatsCard title="Reports" value="59" type="reports" delay={0.1} />
              <StatsCard title="Payroll" value="$96k" type="payroll" delay={0.15} />
              <StatsCard title="Events" value="696" type="events" delay={0.2} />
              <StatsCard title="Projects" value="356" type="projects" delay={0.25} />
              <StatsCard title="Clients" value="3,650" type="clients" delay={0.3} />
              <StatsCard title="Employees" value="96" type="employees" delay={0.35} />
            </motion.div>
            
            {/* Charts */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <div className="lg:col-span-2">
                <RevenueChart />
              </div>
              
              <div className="space-y-6">
                <TotalEarnings />
                <YearlyBreakup />
                <MonthlyEarnings />
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  );
};

export default Index;
