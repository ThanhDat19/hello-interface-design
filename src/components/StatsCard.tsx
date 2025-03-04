
import React from 'react';
import { motion } from 'framer-motion';
import { Activity, DollarSign, Calendar, Mail, Briefcase, Users } from 'lucide-react';

interface StatsCardProps {
  title: string;
  value: string;
  type: 'reports' | 'payroll' | 'events' | 'projects' | 'clients' | 'employees';
  delay?: number;
}

const cardConfig = {
  reports: {
    bgColor: 'bg-stats-reports',
    textColor: 'text-blue-500',
    icon: Activity,
    iconBg: 'bg-blue-100',
  },
  payroll: {
    bgColor: 'bg-stats-payroll',
    textColor: 'text-emerald-500',
    icon: DollarSign,
    iconBg: 'bg-emerald-100',
  },
  events: {
    bgColor: 'bg-stats-events',
    textColor: 'text-red-500',
    icon: Calendar,
    iconBg: 'bg-red-100',
  },
  projects: {
    bgColor: 'bg-stats-projects',
    textColor: 'text-blue-500',
    icon: Mail,
    iconBg: 'bg-blue-100',
  },
  clients: {
    bgColor: 'bg-stats-clients',
    textColor: 'text-amber-500',
    icon: Briefcase,
    iconBg: 'bg-amber-100',
  },
  employees: {
    bgColor: 'bg-stats-employees',
    textColor: 'text-violet-500',
    icon: Users,
    iconBg: 'bg-violet-100',
  },
};

const StatsCard: React.FC<StatsCardProps> = ({ title, value, type, delay = 0 }) => {
  const config = cardConfig[type];
  const Icon = config.icon;
  
  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.4, ease: "easeOut", delay }}
      className={`stats-card ${config.bgColor} stats-card-hover`}
    >
      <div className={`${config.iconBg} card-icon ${config.textColor}`}>
        <Icon size={22} />
      </div>
      
      <div>
        <h3 className="text-slate-600 font-medium text-center">{title}</h3>
        <p className={`text-2xl font-semibold mt-1 ${config.textColor} text-center`}>{value}</p>
      </div>
    </motion.div>
  );
};

export default StatsCard;
