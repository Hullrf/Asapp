import React from "react";
import { FooterSection } from "./FooterSection";
import LOGOA1 from "./LOGO-a-1.png";
import { MainContentSection } from "./MainContentSection";
import { NavigationSection } from "./NavigationSection";

export const Inicio = (): JSX.Element => {
  return (
    <div className="bg-[#ffffff] overflow-hidden w-full min-w-[1280px] min-h-[1311px] relative">
      <NavigationSection />
      <div className="inline-flex h-[93px] items-center gap-6 absolute top-[-11px] left-[1036px]">
        <div className="inline-flex items-center justify-center gap-2 relative flex-[0_0_auto]">
          <div className="relative w-fit [font-family:'Inter-Medium',Helvetica] font-medium text-dark text-base tracking-[0] leading-6 whitespace-nowrap">
            Es
          </div>

          <div className="mt-[-1.00px] [font-family:'Font_Awesome_6_Free-Solid',Helvetica] font-normal text-text text-base text-center tracking-[0] leading-6 relative w-fit whitespace-nowrap"></div>
        </div>

        <button className="all-[unset] box-border gap-2 px-8 py-[18px] relative flex-[0_0_auto] bg-secondary-30 rounded-[99px] border border-solid border-secondary inline-flex items-center justify-center overflow-hidden">
          <div className="mt-[-1.00px] font-link-normal font-[number:var(--link-normal-font-weight)] text-secondary text-[length:var(--link-normal-font-size)] tracking-[var(--link-normal-letter-spacing)] leading-[var(--link-normal-line-height)] relative w-fit whitespace-nowrap [font-style:var(--link-normal-font-style)]">
            REGISTRATE
          </div>
        </button>
      </div>

      <img
        className="absolute top-0 left-0 w-[113px] h-[94px] aspect-[1] object-cover"
        alt="Logo a"
        src={LOGOA1}
      />

      <MainContentSection />
      <FooterSection />
    </div>
  );
};
