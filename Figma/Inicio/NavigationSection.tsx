import React, { useState } from "react";

export const NavigationSection = () => {
  const [activeItem, setActiveItem] = useState("Inicio");

  const navigationItems = [
    { label: "Inicio", isActive: true },
    { label: "Como Funciona", isActive: false },
    { label: "Factura", isActive: false },
    { label: "Base De Datos", isActive: false },
  ];

  const handleNavClick = (label) => {
    setActiveItem(label);
  };

  return (
    <nav
      className="flex w-[706px] h-[67px] items-center gap-10 absolute top-0.5 left-[99px]"
      role="navigation"
      aria-label="Main navigation"
    >
      <div className="inline-flex items-center gap-[11px] relative flex-[0_0_auto]">
        <div className="mt-[-1.00px] text-dark text-xl tracking-[2.00px] leading-6 relative w-fit [font-family:'Inter-Bold',Helvetica] font-bold whitespace-nowrap">
          {""}
        </div>
      </div>

      {navigationItems.map((item, index) => (
        <div
          key={item.label}
          className="inline-flex flex-col items-center justify-center gap-2.5 relative flex-[0_0_auto]"
        >
          <button
            onClick={() => handleNavClick(item.label)}
            className={`relative w-fit mt-[-1.00px] text-base tracking-[0] leading-6 whitespace-nowrap transition-colors duration-200 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 ${
              activeItem === item.label
                ? "[font-family:'Inter-Bold',Helvetica] font-bold text-primary"
                : "[font-family:'Inter-Medium',Helvetica] font-medium text-text hover:text-primary"
            }`}
            aria-current={activeItem === item.label ? "page" : undefined}
          >
            {item.label}
          </button>

          {activeItem === item.label && (
            <div className="absolute top-5 left-[calc(50.00%_-_20px)] w-[41px] h-0.5 bg-primary" />
          )}
        </div>
      ))}

      <div className="inline-flex items-center justify-center gap-2.5 relative flex-[0_0_auto]">
        <div className="relative w-fit mt-[-1.00px] [font-family:'Font_Awesome_6_Free-Solid',Helvetica] font-normal text-colors-labels-vibrant-controls-secondary text-base tracking-[0] leading-6 whitespace-nowrap"></div>
      </div>
    </nav>
  );
};
